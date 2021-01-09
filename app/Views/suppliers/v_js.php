<script>
    <?php if (isset($supplier)) : ?>
        $("[name='supplier_group_id']").val("<?= $supplier->supplier_group_id; ?>");
        $("[name='company_name']").val("<?= $supplier->company_name; ?>");
        $("[name='pic']").val("<?= $supplier->pic; ?>");
        $("[name='pic_phone']").val("<?= $supplier->pic_phone; ?>");
        $("[name='email']").val("<?= $supplier->email; ?>");
        $("[name='address']").val("<?= $supplier->address; ?>");
        $("[name='city']").val("<?= $supplier->city; ?>");
        $("[name='province']").val("<?= $supplier->province; ?>");
        $("[name='country']").val("<?= $supplier->country; ?>");
        $("[name='zipcode']").val("<?= $supplier->zipcode; ?>");
        $("[name='phone']").val("<?= $supplier->phone; ?>");
        $("[name='fax']").val("<?= $supplier->fax; ?>");
        $("[name='nationality']").val("<?= $supplier->nationality; ?>");
        $("[name='remarks']").val("<?= $supplier->remarks; ?>");
        $("[name='npwp']").val("<?= $supplier->npwp; ?>");
        $("[name='nppkp']").val("<?= $supplier->nppkp; ?>");
        $("[name='tax_invoice_no']").val("<?= $supplier->tax_invoice_no; ?>");
        $("[name='coa']").val("<?= $supplier->coa; ?>");
        $("[name='payment_type_id']").val("<?= $supplier->payment_type_id; ?>");
        $("[name='bank_id']").val("<?= $supplier->bank_id; ?>");
        $("[name='bank_account']").val("<?= $supplier->bank_account; ?>");
        $("[name='reg_code']").val("<?= $supplier->reg_code; ?>");
        $("[name='reg_at']").val("<?= $supplier->reg_at; ?>");
        $("[name='join_at']").val("<?= $supplier->join_at; ?>");
        $("[name='description']").val("<?= $supplier->description; ?>");
    <?php endif ?>
</script>