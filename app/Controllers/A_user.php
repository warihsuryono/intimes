<?php

namespace App\Controllers;

use App\Models\m_a_user;
use App\Models\m_a_group;
use App\Models\m_division;

class A_user extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $users;
    protected $groups;
    protected $divisions;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "users";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->users =  new m_a_user();
        $this->groups =  new m_a_group();
        $this->divisions =  new m_division();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Users";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["group_id"]) && $_GET["group_id"] != "")
            $wherclause .= "AND group_id = '" . $_GET["group_id"] . "'";

        if (isset($_GET["email"]) && $_GET["email"] != "")
            $wherclause .= "AND email LIKE '%" . $_GET["email"] . "%'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if (isset($_GET["division_id"]) && $_GET["division_id"] != "")
            $wherclause .= "AND division_id = '" . $_GET["division_id"] . "'";

        if ($users = $this->users->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->users->where($wherclause)->findAll());

            foreach ($users as $user) {
                $user_detail[$user->id]["leader"] = @$this->users->where("id", $user->leader_user_id)->get()->getResult()[0];
                $user_detail[$user->id]["group"] = @$this->groups->where("id", $user->group_id)->get()->getResult()[0];
                $user_detail[$user->id]["division"] = @$this->divisions->where("id", $user->division_id)->get()->getResult()[0];
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["users"] = $users;
        $data["user_detail"] = @$user_detail;
        $data["groups"] = $this->groups->where("is_deleted", 0)->findAll();
        $data["divisions"] = $this->divisions->where("is_deleted", 0)->findAll();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('_users/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $user = [
                "group_id" => @$_POST["group_id"],
                "email" => @$_POST["email"],
                "password" => password_hash(@$_POST["password"], PASSWORD_ARGON2I),
                "name" => @$_POST["name"],
                "job_title" => @$_POST["job_title"],
                "division_id" => @$_POST["division_id"],
                "leader_user_id" => @$_POST["leader_user_id"],
            ];
            $user = $user + $this->created_values() + $this->updated_values();
            if ($this->users->save($user))
                $this->session->setFlashdata("flash_message", ["success", "Success create User"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed create User"]);
            return redirect()->to(base_url() . '/users');
        }

        $data["__modulename"] = "Add User";
        $data["__mode"] = "add";
        $data["users"] = $this->users->where("is_deleted", 0)->findAll();
        $data["groups"] = $this->groups->where("is_deleted", 0)->findAll();
        $data["divisions"] = $this->divisions->where("is_deleted", 0)->findAll();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('_users/v_edit');
        echo view('v_footer');
        echo view('_users/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $signature_filename = "";
            $photo_filename = "";
            if ($img = @$this->request->getFiles()['user_signature'])
                if ($img->isValid() && !$img->hasMoved()) {
                    $signature_filename = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . date("YmdHis") . "_" . $id . "." . pathinfo($img->getName(), PATHINFO_EXTENSION);
                    $img->move('dist/upload/users_signature', $signature_filename);
                }

            if ($img = @$this->request->getFiles()['user_photo'])
                if ($img->isValid() && !$img->hasMoved()) {
                    $photo_filename = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . date("YmdHis") . "_" . $id . "." . pathinfo($img->getName(), PATHINFO_EXTENSION);
                    $img->move('dist/upload/users_photo', $photo_filename);
                }

            $user = [
                "group_id" => @$_POST["group_id"],
                "email" => @$_POST["email"],
                "name" => @$_POST["name"],
                "job_title" => @$_POST["job_title"],
                "division_id" => @$_POST["division_id"],
                "leader_user_id" => @$_POST["leader_user_id"],
            ];
            if ($signature_filename != "") $user = $user + ["signature" => $signature_filename];
            if ($photo_filename != "") $user = $user + ["photo" => $photo_filename];
            if (isset($_POST["password"]) && $_POST["password"] != "")
                $user = $user + ["password" => password_hash($_POST["password"], PASSWORD_ARGON2I)];

            $user = $user + $this->updated_values();
            if ($this->users->update($id, $user))
                $this->session->setFlashdata("flash_message", ["success", "Success editing User"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing User"]);
            return redirect()->to(base_url() . '/users');
        }

        $data["__modulename"] = "Edit User";
        $data["__mode"] = "edit";
        $data["users"] = $this->users->where("is_deleted", 0)->findAll();
        $data["groups"] = $this->groups->where("is_deleted", 0)->findAll();
        $data["divisions"] = $this->divisions->where("is_deleted", 0)->findAll();
        $data["user"] = $this->users->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('_users/v_edit');
        echo view('v_footer');
        echo view('_users/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->users->update($id, ["is_deleted" => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting User"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting User"]);
        return redirect()->to(base_url() . '/users');
    }
}
