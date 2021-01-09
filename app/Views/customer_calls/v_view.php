<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Customer</label><br>
                                <?= (@$customer_call->customer_name != "") ? @$customer_call->customer_name : $customer->company_name; ?><br>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0" style="height: 700px;">
                        <table class="table table-head-fixed text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th><button class="btn btn-primary" onclick="window.location='<?= base_url(); ?>/customer_call/add?customer_id=<?= $customer->id; ?>';"><i class="fa fa-plus"></i></button></th>
                                    <th>No</th>
                                    <th>Call By</th>
                                    <th>Call At</th>
                                    <th>Customer Level</th>
                                    <th>Industry Category</th>
                                    <th>CP</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Next Followup At</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($customer_calls as $customer_call) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/customer_call/edit/<?= $customer_call->id; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="delete_confirmation(<?= $customer_call->id; ?>);">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= @$customer_call_detail[$customer_call->id]["sales_user"]->name; ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($customer_call->call_at)); ?></td>
                                        <td><?= @$customer_call_detail[$customer_call->id]["customer_level"]->name; ?></td>
                                        <td><?= @$customer_call_detail[$customer_call->id]["industry_category"]->name; ?></td>
                                        <td><?= $customer_call->cp; ?></td>
                                        <td><?= $customer_call->phone; ?></td>
                                        <td><?= $customer_call->email; ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($customer_call->next_followup_at)); ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($customer_call->created_at)); ?></td>
                                        <td><?= $customer_call->created_by; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td colspan="10">
                                            <b>Activity : <?= $customer_call->followup_activity; ?></b>
                                            <textarea class="form-control" rows="2" readonly><?= $customer_call->notes; ?></textarea>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                    <div class=" card-footer">
                        <a href="<?= base_url(); ?>/customer_calls" class="btn btn-info">Back</a>
                        <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>