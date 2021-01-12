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
                                                <label>Status</label>
                                                <select name="customer_level_id" class="form-control">
                                                    <option value="">-- Status --</option>
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
                                                    <option value="">-- Category --</option>
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
                                                <label>PIC</label>
                                                <input name="pic" value="<?= @$_GET["pic"]; ?>" type="text" class="form-control" placeholder="PIC ...">
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
                        <button class="btn btn-primary" onclick="window.location='<?= base_url(); ?>/customer/add';"><i class="fa fa-plus"></i></button>
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
                                            <?= ($page % 38 == 0) ? "</ul><br><ul class='pagination'>" : ""; ?>
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
                                    <th>Id</th>
                                    <th>Industry Category</th>
                                    <th>Company Name</th>
                                    <th>Status</th>
                                    <th>PIC</th>
                                    <th>PIC Phone</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>AM</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $startrow;
                                foreach ($customers as $customer) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/customer_call/view?customer_id=<?= $customer->id; ?>">
                                                <i class="fas fa-phone"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal<?= $customer->id; ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/customer/edit/<?= $customer->id; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="delete_confirmation(<?= $customer->id; ?>);">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= $customer->id; ?></td>
                                        <td><?= $customer_detail[$customer->id]["industry_category_id"]; ?></td>
                                        <td><?= $customer->company_name; ?></td>
                                        <td><?= $customer_detail[$customer->id]["customer_level_id"]; ?></td>
                                        <td><?= $customer->pic; ?></td>
                                        <td><?= $customer->pic_phone; ?></td>
                                        <td><?= $customer->email; ?></td>
                                        <td><?= $customer->address; ?></td>
                                        <td><?= $customer->am_by; ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($customer->created_at)); ?></td>
                                        <td><?= $customer->created_by; ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                    <?php foreach ($customers as $customer) : ?>
                        <div class="modal fade" id="exampleModal<?= $customer->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">View Detail</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <td width="200">Id</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->id ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Industry Category</td>
                                                <td width="5">:</td>
                                                <td><?= $customer_detail[$customer->id]["industry_category_id"]; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Company Name</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->company_name ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Prospect</td>
                                                <td width="5">:</td>
                                                <td><?= $customer_detail[$customer->id]["customer_prospect_id"]; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">PIC</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->pic ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">PIC Phone</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->pic_phone ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Email</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->email ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Address</td>
                                                <td width="5">:</td>
                                                <td><?= str_replace([chr(13) . chr(10), "\n"], "<br>", $customer->address) ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">City</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->city ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Province</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->province ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Country</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->country ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">ZIP Code</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->zipcode ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Phone</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->phone ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">FAX</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->fax ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Nationality</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->nationality ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Remarks</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->remarks ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">NPWP</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->npwp ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">NPPKP</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->nppkp ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">TAX Invoice No</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->tax_invoice_no ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Bank</td>
                                                <td width="5">:</td>
                                                <td><?= $customer_detail[$customer->id]["bank_id"]; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Bank Account</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->bank_account ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Reg Code</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->reg_code ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Reg At</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->reg_at ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Join At</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->join_at ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Customer Level Id</td>
                                                <td width="5">:</td>
                                                <td><?= $customer_detail[$customer->id]["customer_level_id"]; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Description</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->description ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Created At</td>
                                                <td width="5">:</td>
                                                <td><?= date("d-m-Y H:i:s", strtotime($customer->created_at)); ?></td>
                                            </tr>
                                            <tr>
                                                <td width="200">Created By</td>
                                                <td width="5">:</td>
                                                <td><?= $customer->created_by ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function delete_confirmation(id) {
        $('#modal_title').html('Delete Customer');
        $('#modal_message').html('Are you sure want to delete this data?');
        $('#modal_type').attr("class", 'modal-content bg-danger');
        $('#modal_ok_link').attr("href", '<?= base_url(); ?>/customer/delete/' + id);
        $('#modal-form').modal();
    }
</script>