<br>
<div style="font-size:14px">
    <div style="display: flex;position:relative;left:50px;">
        <div style="position:relative;width:239px;height:102px;border-bottom:3px solid black;">
            <img src="<?= base_url(); ?>/dist/img/logo_text.png" alt="PT TRUSUR" width="239">
        </div>
        <div style="position:relative;width:670px;height:102px;border-bottom:3px solid black;text-align:right;padding-top:25px;">
            <div style="height:23px;width:100%;background-color:#484848;color:white;font-weight:bolder;padding-right:5px;">PT. TRUSUR UNGGUL TEKNUSA</div>
            <div style="height:23px;width:100%;font-weight:bolder;padding-right:5px;">INVOICE</div>
            <div style="height:23px;width:100%;font-weight:bolder;padding-right:5px;"># <?= $invoice->invoice_no; ?></div>
        </div>
    </div>
    <div style="display: flex;position:relative;left:50px;">
        <div style="position:relative;width:909px;">
            Kepada Yth :
        </div>
    </div>
    <div style="display: flex;position:relative;left:50px;">
        <div style="position:relative;width:539px;">
            <b><?= $customer->company_name; ?></b><br>
            <?= str_replace(chr(13), "<br>", $customer->address); ?>
        </div>
        <div style="position:relative;width:370px;">
            <table>
                <tr>
                    <td style="width:131px;">Tanggal</td>
                    <td> : </td>
                    <td> <?= $_this->format_tanggal($invoice->invoice_at); ?></td>
                </tr>
                <tr>
                    <td>PO. No</td>
                    <td> : </td>
                    <td> <?= $invoice->so_no; ?></td>
                </tr>
                <tr>
                    <td>QAR. No</td>
                    <td> : </td>
                    <td> <?= $so->quotation_no; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div style="display: flex;position:relative;left:50px;">
        <div style="position:relative;width:909px;">
            <b>Attn : Finance</b>
        </div>
    </div>
    <div style="display: flex;position:relative;left:50px;">
        <table style="width:909px;">
            <tr>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">No.</th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">Description</th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;">Qty</th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;" colspan="2">Unit Price</th>
                <th style="height:37px;text-align:center;border:2px solid black;padding:0px;font-weight:bolder;" colspan="2">Total</th>
            </tr>
            <?php
            $no = 0;
            foreach ($invoice_details as $invoice_detail) :
                if ($invoice_detail->item_id > 0) :
                    $no++;
            ?>
                    <tr>
                        <td style="height:20px;border-left:2px solid black;border-right:2px solid black;text-align:center"><?= ($invoice_detail->item_id != "") ? $no : ""; ?></td>
                        <td style="border-right:2px solid black;padding-left:5px;">
                            <?= $invoice_detail_item[$invoice_detail->item_id]->name; ?>
                            <?= ($invoice_detail->notes != "") ? " (" . $invoice_detail->notes . ")" : ""; ?>
                        </td>
                        <td style="border-right:2px solid black;text-align:center"><?= $invoice_detail->qty; ?></td>
                        <td>&nbsp;&nbsp;<?= $currency->symbol; ?></td>
                        <td style="border-right:2px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($invoice_detail->price, 2, $currency->id); ?></td>
                        <td>&nbsp;&nbsp;<?= $currency->symbol; ?></td>
                        <td style="border-right:2px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($invoice_detail->price * $invoice_detail->qty, 2, $currency->id); ?></td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td style="height:20px;border-left:2px solid black;border-right:2px solid black;"></td>
                        <td style="border-right:2px solid black;padding-left:5px;"><?= $invoice_detail->notes; ?></td>
                        <td style="border-right:2px solid black;"></td>
                        <td></td>
                        <td style="border-right:2px solid black;"></td>
                        <td></td>
                        <td style="border-right:2px solid black;"></td>
                    </tr>
                <?php endif  ?>
            <?php endforeach ?>
            <?php for ($ii = 0; $ii < 20 - count($invoice_details); $ii++) : ?>
                <tr>
                    <td style="height:20px;border-left:2px solid black;border-right:2px solid black;"></td>
                    <?php for ($jj = 1; $jj < 7; $jj++) : ?>
                        <td style="height:20px;<?= ($jj != 3 && $jj != 5) ? "border-right:2px solid black;" : ""; ?>"></td>
                    <?php endfor ?>
                </tr>
            <?php endfor ?>
            <tr>
                <td colspan="5" style="height:20px;border-top:2px solid black;border-bottom:2px solid black;padding:0px;text-align:center;">&nbsp;&nbsp;<b>Sub Total</b></td>
                <td style="border-top:2px solid black;border-bottom:2px solid black;">&nbsp;&nbsp;<b><?= $currency->symbol; ?></b></td>
                <td style="border-top:2px solid black;border-bottom:2px solid black;text-align:right;padding-right:5px;"><b><?= $_this->format_amount($invoice->subtotal, 2, $currency->id); ?></b></td>
            </tr>
            <tr>
                <td colspan="5" style="height:20px;border-top:2px solid black;border-bottom:2px solid black;text-align:center;">&nbsp;&nbsp;Disc</td>
                <td style="border-top:2px solid black;border-bottom:2px solid black;">&nbsp;&nbsp;<?= $currency->symbol; ?></td>
                <td style="border-top:2px solid black;border-bottom:2px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($invoice->subtotal * $invoice->disc / 100, 2, $currency->id); ?></td>
            </tr>
            <tr style="font-weight:bolder">
                <td colspan="5" style="height:20px;border-top:2px solid black;border-bottom:2px solid black;text-align:center;">&nbsp;&nbsp;Total</td>
                <td style="border-top:2px solid black;border-bottom:2px solid black;">&nbsp;&nbsp;<?= $currency->symbol; ?></td>
                <td style="border-top:2px solid black;border-bottom:2px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($invoice->after_disc, 2, $currency->id); ?></td>
            </tr>
            <tr>
                <td colspan="5" style="height:20px;border-top:2px solid black;border-bottom:2px solid black;text-align:center;">&nbsp;&nbsp;PPN 10%</td>
                <td style="border-top:2px solid black;border-bottom:2px solid black;">&nbsp;&nbsp;<?= $currency->symbol; ?></td>
                <td style="border-top:2px solid black;border-bottom:2px solid black;text-align:right;padding-right:5px;"><?= $_this->format_amount($invoice->tax, 2, $currency->id); ?></td>
            </tr>
            <tr style="background-color:#484848;color:white;">
                <td colspan="5" style="height:20px;border-top:2px solid black;border-bottom:2px solid black;text-align:center;">&nbsp;&nbsp;<b>Grand Total</b></td>
                <td style="border-top:2px solid black;border-bottom:2px solid black;">&nbsp;&nbsp;<b><?= $currency->symbol; ?></b></td>
                <td style="border-top:2px solid black;border-bottom:2px solid black;text-align:right;padding-right:5px;"><b><?= $_this->format_amount($invoice->total, 2, $currency->id); ?></b></td>
            </tr>
        </table>
    </div>
    <div style="height:23px;"></div>
    <div style="display: flex;position:relative;left:50px;">
        <div style="position:relative;width:909px; border:1px solid black;padding-left:5px;">
            <b>Terbilang :</b><br>
            &nbsp;&nbsp;&nbsp;&nbsp;# <?= $invoice->total_to_say; ?> <?= $currency->name; ?>
        </div>
    </div>
    <div style="height:28px;"></div>
    <div style="display: flex;position:relative;left:50px;">
        <div style="position:relative;width:596px;padding-left:40px;">
            Pembayaran Transfer dapat dilakukan ke :<br>
            <b>Bank Mandiri (Persero) Tbk Cab. Jakarta Cibubur</b><br>
            <b>a/n PT. Trusur Unggul Teknusa</b><br>
            <b>No Rek : 129-00-1090086-4</b><br>
            <b>Mata Uang : <?= $currency->name; ?> / <?= $currency->id; ?></b><br>
        </div>
        <div style="position:relative;width:313px;text-align:center;">
            Hormat Kami
            <?php if ($invoice->is_approved == "0") : ?> <br><br><button class="btn btn-primary d-print-none" onclick="approving();"><i class="fa fa-check"></i> Approve</button> <?php endif ?>
            <div style="position:absolute;top:100px;width:100%"><b><u><?= @$approved_user->name; ?></u></b><br>Finance</div>
        </div>
    </div>
    <div style="height:70px;"></div>
    <div style="display: flex;position:relative;left:50px;">
        <div style="position:relative;width:909px;text-align:center;">
            <b><i>Laboratorium Kalibrasi Gas Analyzer</i></b><br>
            PT. Trusur Unggul Teknusa<br>
            Ruko Jalan Lapangan Tembak Raya No. 64G Cibubur Jakarta 13720<br>
            T. +62 (21) 2962.7001 - 3 F. +62 (21) 2962.7005
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>

<div class="d-print-none card-footer">
    <a href="<?= base_url(); ?>/invoices" class="btn btn-info">Back</a>
    <a href="<?= base_url(); ?>/invoice/edit/<?= $invoice->id; ?>" class="btn btn-info"><i class="fas fa-edit"></i> Edit</a>
    <button class="btn btn-primary" onclick="javascript:window.print()"><i class="fa fa-print"></i> Print</button>
</div>