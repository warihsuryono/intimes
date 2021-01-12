<script>
    <?php if (isset($customer)) : ?>
        $("[name='industry_category_id']").val("<?= $customer->industry_category_id; ?>");
        $("[name='company_name']").val("<?= str_replace([chr(13) . chr(10), "\n"], "<br>", $customer->company_name); ?>".replace("<br>", "\n"));
        $("[name='pic']").val("<?= str_replace([chr(13) . chr(10), "\n"], "<br>", $customer->pic); ?>".replace("<br>", "\n"));
        $("[name='pic_phone']").val("<?= str_replace([chr(13) . chr(10), "\n"], "<br>", $customer->pic_phone); ?>".replace("<br>", "\n"));
        $("[name='email']").val("<?= str_replace([chr(13) . chr(10), "\n"], "<br>", $customer->email); ?>".replace("<br>", "\n"));
        $("[name='address']").val("<?= str_replace([chr(13) . chr(10), "\n"], "<br>", $customer->address); ?>".replace("<br>", "\n"));
        $("[name='city']").val("<?= $customer->city; ?>");
        $("[name='province']").val("<?= $customer->province; ?>");
        $("[name='country']").val("<?= $customer->country; ?>");
        $("[name='zipcode']").val("<?= $customer->zipcode; ?>");
        $("[name='phone']").val("<?= str_replace([chr(13) . chr(10), "\n"], "<br>", $customer->phone); ?>".replace("<br>", "\n"));
        $("[name='fax']").val("<?= $customer->fax; ?>");
        $("[name='nationality']").val("<?= $customer->nationality; ?>");
        $("[name='remarks']").val("<?= $customer->remarks; ?>");
        $("[name='npwp']").val("<?= $customer->npwp; ?>");
        $("[name='nppkp']").val("<?= $customer->nppkp; ?>");
        $("[name='tax_invoice_no']").val("<?= $customer->tax_invoice_no; ?>");
        $("[name='bank_id']").val("<?= $customer->bank_id; ?>");
        $("[name='bank_account']").val("<?= $customer->bank_account; ?>");
        $("[name='reg_code']").val("<?= $customer->reg_code; ?>");
        $("[name='reg_at']").val("<?= $customer->reg_at; ?>");
        $("[name='join_at']").val("<?= $customer->join_at; ?>");
        $("[name='customer_level_id']").val("<?= $customer->customer_level_id; ?>");
        $("[name='customer_prospect_id']").val("<?= $customer->customer_prospect_id; ?>");
        $("[name='description']").val("<?= str_replace([chr(13) . chr(10), "\n"], "<br>", $customer->description); ?>".replace("<br>", "\n"));
        $("[name='am_by']").val("<?= $customer->am_by; ?>");
    <?php endif ?>
</script>