<br>
<div style="font-size:14px">
    <div style="display: flex;position:relative;left:50px;">
        <div style="position:relative;width:241px;height:188px;border:2px solid black;padding-left:5px;">
            <div style="width:100%;text-align:center;padding-top:5px;">
                <img src="<?= base_url(); ?>/dist/img/logo_text.png" alt="PT TRUSUR" height="75">
            </div>
            <b>PT. Trusur Unggul Teknusa</b><br>
            Jl. Lapangan Tembak No. 64 G,<br>
            Cibubur, Jakarta Timur 13720<br>
            INDONESIA<br>
            Telp. +62(21)29627001 - 3
        </div>
        <div style="position:relative;width:375px;height:188px;border:2px solid black;left:-2px;text-align:center;padding-top:50px;font-size:24px;">
            <b>PESANAN PENJUALAN<br><i style="font-size:32px;">( Sales Order )</i></b>
        </div>
        <div style="position:relative;width:325px;height:188px;border:2px solid black;left:-4px;">
            <table cellpadding="0" cellspacing="0" style="width:100%;border-bottom:2px solid black;">
                <tr>
                    <td></td>
                    <td>Date</td>
                    <td>:</td>
                    <td><?= date("d F Y", strtotime($so->so_at)); ?></td>
                </tr>
            </table>
            <table style="position:relative;top:16px;left:16px;width:307px;height:34px;border:2px solid black;">
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;SO. No. : <?= $so->so_no; ?></td>
                </tr>
            </table>
            <div style="position:relative;top:14px;left:16px;width:307px;height:25px;border:2px solid black;"></div>
            <div style="position:relative;top:12px;left:16px;width:307px;height:50px;border:2px solid black;"></div>
        </div>
    </div>
    <div style="display: flex;position:relative;top:-2px;left:50px;">
        <div style="position:relative;width:937px;height:12px;border:2px solid black;"></div>
    </div>
    <div style="display: flex;position:relative;top:-4px;left:50px;">
        <div style="position:relative;width:540px;height:170px;border:2px solid black;padding-left:5px;">
            <b>Alamat Kirim/Consignee Address :</b>
            <div style="height:10px;"></div>
            <b><?= $so->shipment_company; ?></b><br>
            <?= str_replace(chr(13) . chr(10), "<br>", $so->shipment_address); ?><br>
            Phone&nbsp;&nbsp;: <?= $so->shipment_phone; ?>
            <div style="height:8px;"></div>
            Attn&nbsp;&nbsp;&nbsp;: <?= $so->shipment_pic; ?>
        </div>
        <div style="position:relative;width:399px;height:170px;border:2px solid black;left:-2px;padding-left:5px;">
            <b>Kepada/To :</b>
            <div style="height:10px;"></div>
            <b><?= $customer->company_name; ?></b><br>
            <?= str_replace(chr(13) . chr(10), "<br>", $customer->address); ?><br>
            Phone&nbsp;&nbsp;: <?= $customer->pic_phone; ?>
            <div style="height:8px;"></div>
            Attn&nbsp;&nbsp;&nbsp;: <?= $customer->pic; ?>
        </div>
    </div>

    <div style="display: flex;position:relative;left:50px;">
        <div style="position:relative;width:227px;height:39px;border:2px solid black;text-align:center;font-weight:bolder;">Syarat Pembayaran<br><i style="position:relative;top:-4px;font-size:11px">Payment Term</i></div>
        <div style="position:relative;width:374px;height:19px;border:0px;"></div>
        <div style="position:relative;width:312px;height:39px;border:2px solid black;text-align:center;font-weight:bolder;left:24px;">Tgl. Pengiriman<br><i style="position:relative;top:-4px;font-size:11px">Date of Delivery</i></div>
    </div>
    <div style="display: flex;position:relative;top:-2px;left:50px;">
        <div style="position:relative;width:227px;height:19px;border:2px solid black;font-size:12px;text-align:center;"><?= @$payment_type->name; ?></div>
        <div style="position:relative;width:374px;height:19px;border:0px;"></div>
        <div style="position:relative;width:312px;height:19px;border:2px solid black;font-size:12px;text-align:center;left:24px;"><?= ($so->shipment_at != "0000-00-00") ? date("d F Y", strtotime($so->shipment_at)) : "ASAP"; ?></div>
    </div>

    <div style="display: flex;position:relative;top:4px;left:50px;">
        <table style="width:937px;border:2px solid black;">
            <tr>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">No.</th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">Part#</th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">Nama Barang<br>/<i>Description of Goods</i></th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">Jumlah<br>/<i>Quantity</i></th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">Satuan<br>/<i>Unit</i></th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;" colspan="2">Harga/Unit<br>/<i>Unit Price</i></th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;" colspan="2">Jumlah/Total<br>/<i>Total Price</i></th>
            </tr>
            <?php
            $no = 0;
            foreach ($so_details as $so_detail) :
                if ($so_detail->item_id > 0) :
                    $no++;
            ?>
                    <tr>
                        <td style="height:20px;border-right:2px solid black;border-bottom:1px solid black;text-align:center"><?= ($so_detail->item_id != "") ? $no : ""; ?></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;padding-left:5px;"><?= $so_detail_item[$so_detail->item_id]->code; ?></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;padding-left:5px;">
                            <?= $so_detail_item[$so_detail->item_id]->name; ?>
                            <?= "<br>(" . $so_detail_item_scopes[$so_detail->item_id] . ")" ?>
                            <?= ($so_detail->notes != "") ? "<br>(" . $so_detail->notes . ")" : ""; ?>
                        </td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;text-align:center"><?= $so_detail->qty; ?></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;text-align:center"><?= $so_detail_unit[$so_detail->item_id]->name; ?></td>
                        <td style="border-bottom:1px solid black">&nbsp;&nbsp;<?= $currency->symbol; ?></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($so_detail->price, 2, $currency->id); ?></td>
                        <td style="border-bottom:1px solid black">&nbsp;&nbsp;<?= $currency->symbol; ?></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($so_detail->price * $so_detail->qty, 2, $currency->id); ?></td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td style="height:20px;border-right:2px solid black;border-bottom:1px solid black;"></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;"></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;padding-left:5px;"><?= $so_detail->notes; ?></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;"></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;"></td>
                        <td style="border-bottom:1px solid black"></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;"></td>
                        <td style="border-bottom:1px solid black"></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;"></td>
                    </tr>
                <?php endif  ?>
            <?php endforeach ?>
            <?php for ($ii = 0; $ii < 28 - count($so_details); $ii++) : ?>
                <tr>
                    <?php for ($jj = 0; $jj < 9; $jj++) : ?>
                        <td style="height:20px;<?= ($jj != 5 && $jj != 7) ? "border-right:2px solid black;" : ""; ?>border-bottom:1px solid black;"></td>
                    <?php endfor ?>
                </tr>
            <?php endfor ?>
            <tr>
                <td colspan="4" rowspan="5" style="height:22px;border:2px solid black;padding-left:5px;" align="left" valign="top">
                </td>
                <td colspan="3" style="height:20px;border:2px solid black;padding:0px;">&nbsp;&nbsp;<b>Sub Total</b></td>
                <td style="border-bottom:2px solid black;border-top:2px solid black;">&nbsp;&nbsp;<b><?= $currency->symbol; ?></b></td>
                <td style="border-bottom:2px solid black;border-top:2px solid black;text-align:right;padding-right:5px;"><b><?= $_this->format_amount($so->subtotal, 2, $currency->id); ?></b></td>
            </tr>
            <tr>
                <td colspan="3" style="height:20px;border:2px solid black;">&nbsp;&nbsp;Disc</td>
                <td style="border-bottom:2px solid black;">&nbsp;&nbsp;<?= $currency->symbol; ?></td>
                <td style="border-bottom:2px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($so->subtotal * $so->disc / 100, 2, $currency->id); ?></td>
            </tr>
            <tr>
                <td colspan="3" style="height:20px;border:2px solid black;">&nbsp;&nbsp;Total</td>
                <td style="border-bottom:2px solid black;">&nbsp;&nbsp;<?= $currency->symbol; ?></td>
                <td style="border-bottom:2px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($so->after_disc, 2, $currency->id); ?></td>
            </tr>
            <tr>
                <td colspan="3" style="height:20px;border:2px solid black;">&nbsp;&nbsp;PPN/<i>Tax</i></td>
                <td style="border-bottom:2px solid black;">&nbsp;&nbsp;<?= $currency->symbol; ?></td>
                <td style="border-bottom:2px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($so->tax, 2, $currency->id); ?></td>
            </tr>
            <tr>
                <td colspan="3" style="height:20px;border:2px solid black;">&nbsp;&nbsp;<b>Grand Total</b></td>
                <td style="border-bottom:2px solid black;">&nbsp;&nbsp;<b><?= $currency->symbol; ?></b></td>
                <td style="border-bottom:2px solid black;text-align:right;padding-right:5px;"><b><?= $_this->format_amount($so->total, 2, $currency->id); ?></b></td>
            </tr>
            <tr>
                <td colspan="9" style="height:20px;border:2px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;<b>Terbilang : </b><?= $so->total_to_say; ?> <?= $currency->name; ?></td>
            </tr>
        </table>
    </div>
    <div style="display: flex;position:relative;top:10px;left:50px;">
        <div style="position:relative;width:937px;height:23px;border:2px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Catatan : <?= $so->description; ?></div>
    </div>
    <div style="display: flex;position:relative;top:14px;left:50px;">
        <div style="position:relative;width:240px;height:182px;border:2px solid black;text-align:center;">
            <b>Disiapkan/Prepared by,</b>
            <?php if (file_exists("dist/upload/users_signature/" . @$created_user->signature) && @$created_user->signature != "") : ?>
                <br><br><img src="<?= base_url(); ?>/dist/upload/users_signature/<?= @$created_user->signature; ?>" height="90">
            <?php endif ?>
            <div style="position:absolute;top:145px;width:100%"><?= @$created_user->name; ?></div>
        </div>
        <div style="position:relative;width:375px;height:182px;border:0px;left:12px;text-align:center;">

        </div>
        <div style="position:relative;width:310px;height:182px;border:2px solid black;left:12px;text-align:center;">
            <b>Disetujui/Approved by:</b>
            <?php if ($so->is_approved == "0") : ?> <br><br><button class="btn btn-primary d-print-none" onclick="approving();"><i class="fa fa-check"></i> Approve</button> <?php endif ?>
            <?php if (file_exists("dist/upload/users_signature/" . @$approved_user->signature) && @$approved_user->signature != "") : ?>
                <br><br><img src="<?= base_url(); ?>/dist/upload/users_signature/<?= @$approved_user->signature; ?>" height="90">
            <?php endif ?>
            <div style="position:absolute;top:145px;width:100%"><?= @$approved_user->name; ?></div>
        </div>
    </div>
</div>
<br>

<div class="d-print-none card">
    <div class="card-body">
        <h4 class="card-title"><b>Uploaded Documents</b></h4>
        <table class="table table-head-fixed text-nowrap table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>File Type</th>
                    <th>Dok No</th>
                    <th>File</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (@$so_files as $xx => $so_file) : ?>
                    <tr>
                        <td><?= ($xx + 1); ?></td>
                        <td><?= $so_file->file_types; ?></td>
                        <td><?= $so_file->dok_no; ?></td>
                        <td><a target='_BLANK' href='/downloads/<?= $so_file->files; ?>'><?= $so_file->files; ?></a></td>
                        <td><?= $so_file->notes; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<br>

<div class="d-print-none card-footer">
    <a href="<?= base_url(); ?>/so" class="btn btn-info">Back</a>
    <a href="<?= base_url(); ?>/so/edit/<?= $so->id; ?>" class="btn btn-info"><i class="fas fa-edit"></i> Edit</a>
    <a href="<?= base_url(); ?>/invoice/add?so_no=<?= $so->so_no; ?>" class="btn btn-info"><i class="fas fa-file-invoice nav-icon"></i> Create Invoice</a>
    <button class="btn btn-primary" onclick="javascript:window.print()"><i class="fa fa-print"></i> Print</button>
</div>