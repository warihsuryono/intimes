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
            <b>Purchase Request</b>
        </div>
        <div style="position:relative;width:325px;height:188px;border:2px solid black;left:-4px;">
            <table cellpadding="0" cellspacing="0" style="width:100%;border-bottom:2px solid black;">
                <tr>
                    <td>&nbsp;&nbsp;</td>
                    <td style="width:100px;" nowrap>PR No</td>
                    <td>:&nbsp;&nbsp;</td>
                    <td><?= $pr->pr_no; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Date</td>
                    <td>:</td>
                    <td><?= date("d F Y", strtotime($pr->pr_at)); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div style="display: flex;position:relative;top:4px;left:50px;">
        <table style="width:937px;border:2px solid black;">
            <tr>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">No.</th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">Part#</th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">Nama Barang<br>/<i>Description of Goods</i></th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;"><i>Qty</i></th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">Satuan<br>/<i>Unit</i></th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;"><i>Notes</i></th>
            </tr>
            <?php
            $no = 0;
            foreach ($pr_details as $pr_detail) :
                $no++;
            ?>
                <tr>
                    <td style="height:20px;border-right:2px solid black;border-bottom:1px solid black;text-align:center"><?= $no; ?></td>
                    <td style="border-right:2px solid black;border-bottom:1px solid black;padding-left:5px;"><?= $pr_detail_item[$pr_detail->item_id]->code; ?></td>
                    <td style="border-right:2px solid black;border-bottom:1px solid black;padding-left:5px;"><?= $pr_detail_item[$pr_detail->item_id]->name; ?></td>
                    <td style="border-right:2px solid black;border-bottom:1px solid black;text-align:center"><?= $pr_detail->qty; ?></td>
                    <td style="border-right:2px solid black;border-bottom:1px solid black;padding-left:5px;"><?= $pr_detail_unit[$pr_detail->item_id]->name; ?></td>
                    <td style="border-right:2px solid black;border-bottom:1px solid black;text-align:center"><?= $pr_detail->notes; ?></td>
                </tr>
            <?php endforeach ?>
            <?php for ($ii = 0; $ii < 35 - count($pr_details); $ii++) : ?>
                <tr>
                    <?php for ($jj = 0; $jj < 6; $jj++) : ?>
                        <td style="height:20px;border-right:2px solid black;border-bottom:1px solid black;"></td>
                    <?php endfor ?>
                </tr>
            <?php endfor ?>
        </table>
    </div>
    <div style="display: flex;position:relative;top:10px;left:50px;">
        <div style="position:relative;width:937px;height:23px;border:2px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Catatan : <?= $pr->description; ?></div>
    </div>
    <div style="display: flex;position:relative;top:14px;left:50px;">
        <div style="position:relative;width:228px;height:182px;border:2px solid black;text-align:center;">
            <b>Disiapkan/Prepared by,</b>
            <?php if (file_exists("dist/upload/users_signature/" . @$created_user->signature) && @$created_user->signature != "") : ?>
                <br><br><img src="<?= base_url(); ?>/dist/upload/users_signature/<?= @$created_user->signature; ?>" height="90">
            <?php endif ?>
            <div style="position:absolute;top:145px;width:100%"><?= @$created_user->name; ?></div>
        </div>
    </div>
</div>
<br>
<br>

<div class="d-print-none card-footer">
    <a href="<?= base_url(); ?>/pr" class="btn btn-info">Back</a>
    <?php if (!$pr->is_po) : ?>
        <a href="<?= base_url(); ?>/pr/edit/<?= $pr->id; ?>" class="btn btn-info"><i class="fas fa-edit"></i> Edit</a>
    <?php endif ?>
    <a href="<?= base_url(); ?>/po/add?pr_no=<?= @$pr->pr_no; ?>" class="btn btn-info"><i class="fas fa-shopping-cart"></i> Create Supplier PO</a>
    <button class="btn btn-primary" onclick="javascript:window.print()"><i class="fa fa-print"></i> Print</button>
</div>