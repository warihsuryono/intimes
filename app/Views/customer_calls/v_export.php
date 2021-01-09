<table class="border:1px solid black;">
    <thead>
        <tr>
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