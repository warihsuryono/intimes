<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$data["__modulename"] = "Home";
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('v_home');
		echo view('v_footer');
	}

	public function changepassword()
	{
		if (isset($_POST["changepassword"])) {
			$current_password = $this->users->where("id", $this->session->get("user_id"))->where("is_deleted", 0)->findAll()[0]->password;
			if (password_verify($_POST["old_password"], $current_password)) {
				if (preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/i", $_POST["new_password"])) {
					if ($_POST["new_password"] == $_POST["retype_password"]) {
						$this->users->update($this->session->get("user_id"), ["password" => password_hash($_POST["new_password"], PASSWORD_ARGON2I)] + $this->updated_values());
						$this->session->setFlashdata("flash_message", ["success", "Password changed successfully"]);
						return redirect()->to(base_url() . '/');
					} else {
						$this->session->setFlashdata("flash_message", ["error", "Retype new password not match"]);
						return redirect()->to(base_url() . '/changepassword');
					}
				} else {
					$this->session->setFlashdata("flash_message", ["error", "New password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"]);
					return redirect()->to(base_url() . '/changepassword');
				}
			} else {
				$this->session->setFlashdata("flash_message", ["error", "Wrong old password"]);
				return redirect()->to(base_url() . '/changepassword');
			}
		}
		$data["__modulename"] = "Change Password";
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('v_changepassword');
		echo view('v_footer');
	}

	function mime_type($path)
	{
		$ext = explode('.', $path);
		$ext = $ext[count($ext) - 1];
		if (in_array($ext, array('htm', 'html', 'php', 'phtml', 'php3', 'php4', 'php5', 'php5', 'php6'))) {
			return 'text/html';
		} else {
			if (in_array($ext, array('js', 'jscript'))) {
				return 'text/javascript';
			} else {
				if (in_array($ext, array('css', 'css3'))) {
					return 'text/css';
				} else {
					if (in_array($ext, array('sql'))) {
						return 'text/plain';
					} else {
						if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {
							return 'image/' . str_replace('jpg', 'jpeg', $ext);
						} else {
							return "";
						}
					}
				}
			}
		}
	}

	public function downloads($fileName = NULL)
	{
		if ($fileName) {
			$path = WRITEPATH . 'uploads/' . $fileName;
			if (file_exists($path)) {
				$mime = $this->mime_type($path);
				header('Pragma: public');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
				header('Cache-Control: private', false);
				header('Content-Type: ' . $mime);
				header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');  // Add the file name
				header('Content-Transfer-Encoding: binary');
				header('Content-Length: ' . filesize($path));
				header('Connection: close');
				readfile($path);
			}
		}
		exit();
	}
}
