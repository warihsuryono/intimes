<br>
<div style="font-size:14px">
    <div style="display: flex;position:relative;left:50px;">
        <div style="position:relative;width:199px;height:199px;border-bottom:3px solid black;">
            <img src="<?= base_url(); ?>/dist/img/logo_text_2.png" alt="INTIMES" width="190">
        </div>
        <div style="position:relative;width:596px;height:199px;border-bottom:3px solid black;text-align:center;padding-top:40px;">
            <b style="font-weight:bolder;font-size:30px;">PT. CAHAYA BERKAT ABADI</b><br>
            Ruko Grand Galaxy City Blok RSA5 No.2, Jaka Setia, Bekasi Selatan, Kota Bekasi, Jawa Barat 17147<br>
            Telp: (021) 82731502 ext. 189<br>
            <u>www.intimessolution.com</u>
        </div>
        <div style="position:relative;width:170px;height:199px;border-bottom:3px solid black;padding-top:5px;padding-left:20px;">
            <img src="<?= base_url(); ?>/dist/img/logo_kan.png" alt="KAN" width="142">
            <div style="position:relative;top:-10px;"> <img src="<?= base_url(); ?>/dist/img/logo_iso9001_2015.png" alt="logo_iso9001_2015" width="142"></div>
        </div>
    </div>
    <div style="display: flex;position:relative;">
        <div style="position:relative;left:845px;height:45px;padding-top:20px;">
            Jakarta, <?= $_this->format_tanggal($quotation->quotation_at); ?>
        </div>
    </div>
    <div style="display: flex;position:relative;left:50px;">
        <div>
            Kepada Yth.:<br>
            <b><?= $customer->company_name; ?></b><br>
            <?= str_replace(chr(13) . chr(10), "<br>", $customer->address); ?>
            <?php if ($quotation->attn != "") : ?>
                <br><?= $quotation->attn; ?>
            <?php endif ?>
        </div>
    </div>
    <div style="height:28px;"></div>
    <div style="display: flex;position:relative;left:50px;">
        <div style="width:965px;text-align:center;">
            <u>PENAWARAN HARGA</u><br>
            No. <?= $quotation->quotation_no; ?>
        </div>
    </div>
    <div style="height:51px;"></div>
    <div style="display: flex;position:relative;left:50px;">
        <div style="width:965px;">
            <?php if ($quotation->request_no != "" || $quotation->request_at != "0000-00-00") : ?>
                Berdasarkan Surat Permintaan Penawaran Harga <?= ($quotation->request_no != "") ? "No. " . $quotation->request_no : "" ?> <?= ($quotation->request_at != "0000-00-00") ? "tanggal " . $_this->format_tanggal($quotation->request_at) : ""; ?>,
            <?php endif ?>
            Bersama ini kami sampaikan penawaran harga sebagai berikut :
        </div>
    </div>
    <div style="height:11px;"></div>
    <div style="display: flex;position:relative;left:50px;">
        <div style="width:965px;">
            <table style="width:965px;border:1px solid black;">
                <tr style="background-color:lightgrey;">
                    <th style="height:48px;text-align:center;border:1px solid black;font-weight:bolder;">No</th>
                    <th style="height:48px;text-align:center;border:1px solid black;font-weight:bolder;">Kode #</th>
                    <th style="height:48px;text-align:center;border:1px solid black;font-weight:bolder;letter-spacing:3px;">Description</th>
                    <th style="height:48px;text-align:center;border:1px solid black;font-weight:bolder;">Qty</th>
                    <th style="height:48px;text-align:center;border:1px solid black;font-weight:bolder;">Unit Price<br>(<?= $currency->symbol; ?>)</th>
                    <th style="height:48px;text-align:center;border:1px solid black;font-weight:bolder;">Total Price<br>(<?= $currency->symbol; ?>)</th>
                </tr>
                <?php
                $no = 0;
                foreach ($quotation_details as $quotation_detail) :
                    if ($quotation_detail->item_id > 0) :
                        $no++;
                ?>
                        <tr>
                            <td style="height:20px;border-right:1px solid black;border-bottom:1px solid black;text-align:center"><?= ($quotation_detail->item_id != "") ? $no : ""; ?></td>
                            <td style="border-right:1px solid black;border-bottom:1px solid black;padding-left:5px;"><?= $quotation_detail_item[$quotation_detail->item_id]->code; ?></td>
                            <td style="border-right:1px solid black;border-bottom:1px solid black;padding-left:5px;">
                                <?= $quotation_detail_item[$quotation_detail->item_id]->name; ?>
                                <?= "<br>(" . $quotation_detail_item_scopes[$quotation_detail->item_id] . ")" ?>
                                <?= ($quotation_detail->notes != "") ? "<br>(" . $quotation_detail->notes . ")" : ""; ?>
                            </td>
                            <td style="border-right:1px solid black;border-bottom:1px solid black;text-align:center"><?= $quotation_detail->qty; ?></td>
                            <td style="border-right:1px solid black;border-bottom:1px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($quotation_detail->price, 2, $currency->id); ?></td>
                            <td style="border-right:1px solid black;border-bottom:1px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($quotation_detail->price * $quotation_detail->qty, 2, $currency->id); ?></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td style="height:20px;border-right:1px solid black;border-bottom:1px solid black;"></td>
                            <td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
                            <td style="border-right:1px solid black;border-bottom:1px solid black;padding-left:5px;"><?= $quotation_detail->notes; ?></td>
                            <td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
                            <td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
                            <td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
                        </tr>
                    <?php endif  ?>
                <?php endforeach ?>
                <tr>
                    <td style="height:20px;border-right:1px solid black;border-bottom:1px solid black;"></td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;" colspan="3"></td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
                </tr>
                <tr>
                    <td style="height:20px;border-right:1px solid black;border-bottom:1px solid black;"></td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;text-align:right;padding-right:10px;" colspan="3">Subtotal</td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($quotation->subtotal, 2, $currency->id); ?></td>
                </tr>
                <tr>
                    <td style="height:20px;border-right:1px solid black;border-bottom:1px solid black;"></td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;text-align:right;padding-right:10px;" colspan="3">Diskon <?= ($quotation->disc * 1); ?>%</td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($quotation->subtotal * $quotation->disc / 100, 2, $currency->id); ?></td>
                </tr>
                <tr>
                    <td style="height:20px;border-right:1px solid black;border-bottom:1px solid black;"></td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;text-align:right;padding-right:10px;" colspan="3">Total</td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($quotation->after_disc, 2, $currency->id); ?></td>
                </tr>
                <tr>
                    <td style="height:20px;border-right:1px solid black;border-bottom:1px solid black;"></td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;text-align:right;padding-right:10px;" colspan="3">PPN 10%</td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($quotation->tax, 2, $currency->id); ?></td>
                </tr>
                <tr>
                    <td style="height:20px;border-right:1px solid black;border-bottom:1px solid black;"></td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;text-align:right;padding-right:10px;" colspan="3"><b>GRAND TOTAL</b></td>
                    <td style="border-right:1px solid black;border-bottom:1px solid black;text-align:right;padding-right:5px;"><b><?= $_this->format_amount($quotation->total, 2, $currency->id); ?></b></td>
                </tr>
            </table>
        </div>
    </div>
    <div style="height:11px;"></div>
    <div style="display: flex;position:relative;left:50px;">
        <div style="width:965px;">
            <u>Kondisi Penawaran :</u><br>
            <table>
                <tr>
                    <td width="182">Harga</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?= $quotation->price_notes; ?></td>
                </tr>
                <tr>
                    <td>Pembayaran</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?= $quotation->payment_notes; ?></td>
                </tr>
                <tr>
                    <td>Pengerjaan</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?= $quotation->execution_time; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?= $quotation->execution_at; ?></td>
                </tr>
                <tr>
                    <td>Validasi</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?= $quotation->validation_notes; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div style="height:57px;"></div>
    <div style="display: flex;position:relative;left:50px;">
        <div style="width:965px;">
            Hormat Kami,<br>
            <b>PT. Cahaya Berkat Abadi</b>
            <?php if ($quotation->is_approved == "0") : ?> <br><br><button class="btn btn-primary d-print-none" onclick="approving();"><i class="fa fa-check"></i> Approve</button> <?php endif ?>
            <?php if (file_exists("dist/upload/users_signature/" . @$approved_user->signature) && @$approved_user->signature != "") : ?>
                <br><br><img src="<?= base_url(); ?>/dist/upload/users_signature/<?= @$approved_user->signature; ?>" height="90">
            <?php endif ?>
            <div style="position:absolute;top:150px;width:100%"><u><?= @$approved_user->name; ?></u><br>Sales Manager</div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>

<div class="d-print-none card-footer">
    <a href="<?= base_url(); ?>/quotation" class="btn btn-info">Back</a>
    <a href="<?= base_url(); ?>/quotation/edit/<?= $quotation->id; ?>" class="btn btn-info"><i class="fas fa-edit"></i> Edit</a>
    <a href="<?= base_url(); ?>/quotation/revision/<?= $quotation->id; ?>" class="btn btn-info"><i class="fas fa-copy"></i> Revision</a>
    <a href="<?= base_url(); ?>/so/add?quotation_no=<?= $quotation->quotation_no; ?>" class="btn btn-info"><i class="fas fa-envelope-open-text"></i> Create Sales Order</a>
    <button class="btn btn-primary" onclick="javascript:window.print()"><i class="fa fa-print"></i> Print</button>
</div>