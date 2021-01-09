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
            <b>Item Receive</b>
        </div>
        <div style="position:relative;width:325px;height:188px;border:2px solid black;left:-4px;">
            <table cellpadding="0" cellspacing="0" style="width:100%;border-bottom:2px solid black;">
                <tr>
                    <td>&nbsp;&nbsp;</td>
                    <td style="width:100px;" nowrap>Receive No</td>
                    <td>:&nbsp;&nbsp;</td>
                    <td><?= $item_receive->item_receive_no; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Date</td>
                    <td>:</td>
                    <td><?= date("d F Y", strtotime($item_receive->item_receive_at)); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Shipment Date</td>
                    <td>:</td>
                    <td><?= date("d F Y", strtotime($item_receive->shipment_at)); ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div style="display: flex;position:relative;top:-2px;left:50px;">
        <div style="position:relative;width:937px;height:12px;border:2px solid black;"></div>
    </div>
    <div style="display: flex;position:relative;top:-4px;left:50px;">
        <div style="position:relative;width:540px;height:170px;border:2px solid black;padding-left:5px;">
            <b>Alamat Kirim/Consignee Address :</b>
            <div style="height:10px;"></div>
            <b><?= $item_receive->shipment_company; ?></b><br>
            <?= str_replace(chr(13) . chr(10), "<br>", $item_receive->shipment_address); ?><br>
            Phone&nbsp;&nbsp;: <?= $item_receive->shipment_phone; ?>
            <div style="height:8px;"></div>
            Attn&nbsp;&nbsp;&nbsp;: <?= $item_receive->shipment_pic; ?>
        </div>
        <div style="position:relative;width:399px;height:170px;border:2px solid black;left:-2px;padding-left:5px;">
            <b>Supplier :</b>
            <div style="height:10px;"></div>
            <b><?= $supplier->company_name; ?></b><br>
            <?= str_replace(chr(13) . chr(10), "<br>", $supplier->address); ?><br>
            Phone&nbsp;&nbsp;: <?= $supplier->pic_phone; ?>
            <div style="height:8px;"></div>
            Attn&nbsp;&nbsp;&nbsp;: <?= $supplier->pic; ?>
        </div>
    </div>

    <div style="display: flex;position:relative;top:4px;left:50px;">
        <table style="width:937px;border:2px solid black;">
            <tr>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">No.</th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">Part#</th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">Nama Barang<br>/<i>Description of Goods</i></th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">Satuan<br>/<i>Unit</i></th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;"><i>PO Quantity</i></th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;"><i>PO Outstanding</i></th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;"><i>PO Receive</i></th>
            </tr>
            <?php
            $no = 0;
            foreach ($item_receive_details as $item_receive_detail) :
                if ($item_receive_detail->item_id > 0) :
                    $no++;
            ?>
                    <tr>
                        <td style="height:20px;border-right:2px solid black;border-bottom:1px solid black;text-align:center"><?= ($item_receive_detail->item_id != "") ? $no : ""; ?></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;padding-left:5px;"><?= $item_receive_detail_item[$item_receive_detail->item_id]->code; ?></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;padding-left:5px;"><?= $item_receive_detail_item[$item_receive_detail->item_id]->name; ?></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;text-align:center"><?= $item_receive_detail_unit[$item_receive_detail->item_id]->name; ?></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;text-align:center"><?= $item_receive_detail->qty_po; ?></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;text-align:center"><?= $item_receive_detail->qty_outstanding; ?></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;text-align:center"><?= $item_receive_detail->qty; ?></td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td style="height:20px;border-right:2px solid black;border-bottom:1px solid black;"></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;"></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;padding-left:5px;"><?= $item_receive_detail->notes; ?></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;"></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;"></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;"></td>
                        <td style="border-right:2px solid black;border-bottom:1px solid black;"></td>
                    </tr>
                <?php endif  ?>
            <?php endforeach ?>
            <?php for ($ii = 0; $ii < 28 - count($item_receive_details); $ii++) : ?>
                <tr>
                    <?php for ($jj = 0; $jj < 7; $jj++) : ?>
                        <td style="height:20px;border-right:2px solid black;border-bottom:1px solid black;"></td>
                    <?php endfor ?>
                </tr>
            <?php endfor ?>
        </table>
    </div>
    <div style="display: flex;position:relative;top:10px;left:50px;">
        <div style="position:relative;width:937px;height:23px;border:2px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Catatan : <?= $item_receive->description; ?></div>
    </div>
    <div style="display: flex;position:relative;top:14px;left:50px;">
        <div style="position:relative;width:228px;height:182px;border:2px solid black;text-align:center;">
            <b>Disiapkan/Prepared by,</b>
            <?php if (file_exists("dist/upload/users_signature/" . @$created_user->signature) && @$created_user->signature != "") : ?>
                <br><br><img src="<?= base_url(); ?>/dist/upload/users_signature/<?= @$created_user->signature; ?>" height="90">
            <?php endif ?>
            <div style="position:absolute;top:145px;width:100%"><?= @$created_user->name; ?></div>
        </div>
        <div style="position:relative;width:322px;"></div>
        <div style="position:relative;width:375px;height:182px;border:2px solid black;left:12px;text-align:center;">
            <b>Disetujui/Approved by:</b>
            <?php if ($item_receive->is_approved == "0") : ?> <br><br><button class="btn btn-primary d-print-none" onclick="approving();"><i class="fa fa-check"></i> Approve</button> <?php endif ?>
            <?php if (file_exists("dist/upload/users_signature/" . @$approved_user->signature) && @$approved_user->signature != "") : ?>
                <br><br><img src="<?= base_url(); ?>/dist/upload/users_signature/<?= @$approved_user->signature; ?>" height="90">
            <?php endif ?>
            <div style="position:absolute;top:145px;width:100%"><?= @$approved_user->name; ?></div>
        </div>
    </div>
</div>
<br>
<br>

<div class="d-print-none card-footer">
    <a href="<?= base_url(); ?>/item_receives" class="btn btn-info">Back</a>
    <?php if (!$item_receive->is_approved) : ?>
        <a href="<?= base_url(); ?>/item_receive/edit/<?= $item_receive->id; ?>" class="btn btn-info"><i class="fas fa-edit"></i> Edit</a>
    <?php endif ?>
    <button class="btn btn-primary" onclick="javascript:window.print()"><i class="fa fa-print"></i> Print</button>
</div>