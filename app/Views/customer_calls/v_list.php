<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <!--FILTER -->
                <div class="card collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Filter</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0" style="display: none;">
                        <div class="d-md-flex">
                            <div class="p-1 flex-fill" style="overflow: hidden">
                                <form method="GET" id="filter_form">
                                    <input type="hidden" id="page" name="page" value="1">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Level</label>
                                                <select name="customer_level_id" class="form-control">
                                                    <option value="">-- Level --</option>
                                                    <?php foreach ($customer_levels as $customer_level) : ?>
                                                        <option value="<?= $customer_level->id; ?>" <?= (@$_GET["customer_level_id"] == $customer_level->id) ? "selected" : ""; ?>><?= $customer_level->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Industry Category</label>
                                                <select name="industry_category_id" class="form-control">
                                                    <option value="">-- History Type --</option>
                                                    <?php foreach ($industry_categories as $industry_category) : ?>
                                                        <option value="<?= $industry_category->id; ?>" <?= (@$_GET["industry_category_id"] == $industry_category->id) ? "selected" : ""; ?>><?= $industry_category->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input name="company_name" value="<?= @$_GET["company_name"]; ?>" type="text" class="form-control" placeholder="Company Name ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Contact Person</label>
                                                <input name="cp" value="<?= @$_GET["cp"]; ?>" type="text" class="form-control" placeholder="Contact Person ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input name="phone" value="<?= @$_GET["phone"]; ?>" type="text" class="form-control" placeholder="Phone ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input name="email" value="<?= @$_GET["email"]; ?>" type="text" class="form-control" placeholder="Email ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Call At</label>
                                                <input name="call_at" value="<?= @$_GET["call_at"]; ?>" type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Call By</label>
                                                <input name="call_by" value="<?= @$_GET["call_by"]; ?>" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Next Followup At</label>
                                                <input name="next_followup_at" value="<?= @$_GET["next_followup_at"]; ?>" type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>AM</label>
                                                <input name="am_by" value="<?= @$_GET["am_by"]; ?>" type="text" class="form-control" placeholder="AM ...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-right">
                                            <input type="reset" onclick="window.location='?';" class="btn btn-default" value="Reset">
                                            <input type="submit" class="btn btn-primary" value="Search">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--END FILTER -->
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-2">
                        <button class="btn btn-primary" onclick="window.location='<?= base_url(); ?>/customer_call/add';"><i class="fa fa-plus"></i></button>
                        <button class="btn btn-success" onclick="window.open('<?= base_url(); ?>/customer_calls?<?= $_SERVER['QUERY_STRING']; ?>&exporttoxls=true');"><i class="fas fa-file-excel"></i></button>
                    </div>
                </div>
                <div class="card">
                    <!--PAGING -->
                    <?php if ($numrow > MAX_ROW) : ?>
                        <?php if (!isset($_GET["page"])) $_GET["page"] = 1; ?>
                        <div class="card-header">
                            <div class="card-tools">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button page-item previous" id="example2_previous"><a onclick="$('#page').val('1');$('#filter_form').submit();" href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">First</a></li>
                                        <?php for ($page = 1; $page <= $maxpage; $page++) : ?>
                                            <li class="paginate_button page-item <?= ($_GET["page"] == $page) ? "active" : "" ?>"><a onclick="$('#page').val('<?= $page; ?>');$('#filter_form').submit();" href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link"><?= $page; ?></a></li>
                                        <?php endfor ?>
                                        <li class="paginate_button page-item next" id="example2_next"><a onclick="$('#page').val('<?= $maxpage; ?>');$('#filter_form').submit();" href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Last</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <!--END PAGING -->
                    <div class="card-body table-responsive p-0" style="height: 700px;">
                        <table class="table table-head-fixed text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>Call By</th>
                                    <th>Call At</th>
                                    <th>Customer Level</th>
                                    <th>Industry Category</th>
                                    <th>Company Name</th>
                                    <th>CP</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Next Followup At</th>
                                    <th>Notes</th>
                                    <th>AM</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $startrow;
                                foreach ($customer_calls as $customer_call) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/customer_call/view/?customer_id=<?= $customer_call->customer_id; ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
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
                                        <td><?= @$customer_call_detail[$customer_call->id]["customer"]->company_name; ?></td>
                                        <td><?= $customer_call->cp; ?></td>
                                        <td><?= $customer_call->phone; ?></td>
                                        <td><?= $customer_call->email; ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($customer_call->next_followup_at)); ?></td>
                                        <td><?= substr($customer_call->notes, 0, 200); ?></td>
                                        <td><?= @$customer_call_detail[$customer_call->id]["customer"]->am_by; ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($customer_call->created_at)); ?></td>
                                        <td><?= $customer_call->created_by; ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function delete_confirmation(id) {
        $('#modal_title').html('Delete Customer call');
        $('#modal_message').html('Are you sure want to delete this data?');
        $('#modal_type').attr("class", 'modal-content bg-danger');
        $('#modal_ok_link').attr("href", '<?= base_url(); ?>/customer_call/delete/' + id);
        $('#modal-form').modal();
    }
</script>