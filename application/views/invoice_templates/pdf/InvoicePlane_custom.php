<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">


<?php  $separator = ' | ' ?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php _trans('invoice'); ?></title>
    <link rel="stylesheet"
        href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/templates.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom-pdf.css">
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <?php echo invoice_logo_pdf(); ?>
        </div>

        <div id="company">
            <div><b><?php _htmlsc($invoice->user_name); ?></b>
            <?php 
            if ($invoice->user_address_1) {
                echo $separator . htmlsc($invoice->user_address_1);
            }
            if ($invoice->user_address_2) {
                echo  $separator .  htmlsc($invoice->user_address_2);
            }
            if ($invoice->user_city || $invoice->user_state || $invoice->user_zip) {
                echo $separator;
                if ($invoice->user_zip) {
                    echo htmlsc($invoice->user_zip) . ' 'gi;
                }
                if ($invoice->user_city) {
                    echo htmlsc($invoice->user_city) . ' ';
                }
            }


            echo '</div>';
        ?>
        </div>

        <div id="client">
            <div>

                <b><?php _htmlsc(format_client($invoice)); ?>
                <?php 
                if (isset($custom_fields['client']['Ansprechpartner']) ) {
                    echo '<div>' . htmlsc($custom_fields['client']['Ansprechpartner']) . '</div>';
                } ?>
            </div>
            <?php
            if ($invoice->client_address_1) {
                echo '<div>' . htmlsc($invoice->client_address_1) . '</div>';
            }
            if ($invoice->client_address_2) {
                echo '<div>' . htmlsc($invoice->client_address_2) . '</div>';
            }
            if ($invoice->client_city || $invoice->client_state || $invoice->client_zip) {
                echo '<div>';
                if ($invoice->client_zip) {
                    echo htmlsc($invoice->client_zip) . ' ';
                }
                if ($invoice->client_city) {
                    echo htmlsc($invoice->client_city) . ' ';
                }
                /*if ($invoice->client_state) {
                    echo htmlsc($invoice->client_state) . ' ';
                }*/
                echo '</div>';
            }
            if ($invoice->client_country) {
                echo '<div>' . get_country_name(trans('cldr'), $invoice->client_country) . '</div>';
            }



            if ($invoice->client_phone) {
                echo '<div>' . trans('phone_abbr') . ': ' . htmlsc($invoice->client_phone) . '</div>';
            } ?>
        </div>
    </header>

    <main>
        <div class="invoice-details clearfix">
            <table>
                <tr>
                    <td><?php echo trans('invoice_date') . ':'; ?></td>
                    <td><?php echo date_from_mysql($invoice->invoice_date_created, true); ?></td>
                </tr>
                <tr>
                    <td><?php echo trans('due_date') . ': '; ?></td>
                    <td><?php echo date_from_mysql($invoice->invoice_date_due, true); ?></td>
                </tr>
                <tr>
                    <td><?php echo trans('amount_due') . ': '; ?></td>
                    <td><?php echo format_currency($invoice->invoice_balance); ?></td>
                </tr>
                <?php if ($payment_method): ?>
                <tr>
                    <td><?php echo trans('payment_method') . ': '; ?></td>
                    <td><?php _htmlsc($payment_method->payment_method_name); ?></td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
        <h1 class="invoice-title"><?php echo trans('invoice') . ' ' . $invoice->invoice_number; ?></h1>
        <div class="invoice-subject">
            <?php 
            if (isset($custom_fields['invoice']['Invoice Subject']) ) {
                print_r( $custom_fields['invoice']['Invoice Subject']);
            }?>
        </div>
        <table class="item-table">
            <thead>
                <tr>
                    <th class="item-name"><?php _trans('item'); ?></th>
                    <th class="item-desc"><?php _trans('description'); ?></th>
                    <th class="item-amount text-right"><?php _trans('qty'); ?></th>
                    <th class="item-price text-right"><?php _trans('price'); ?></th>
                    <?php if ($show_item_discounts ) : ?>
                        <th class="item-discount text-right"><?php _trans('discount'); ?></th>
                    <?php endif; ?>
                    <th class="item-total text-right"><?php _trans('total'); ?></th>
                </tr>
            </thead>
            <tbody>

            <?php
            foreach ($items as $item) { ?>
            <tr>
                <td><?php _htmlsc($item->item_name); ?></td>
                <td><?php echo nl2br(($item->item_description)); ?></td>
                <td class="text-right">
                    <?php echo format_amount($item->item_quantity); ?>
                    <?php if ($item->item_product_unit) : ?>
                    <br>
                    <small><?php _htmlsc($item->item_product_unit); ?></small>
                    <?php endif; ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($item->item_price); ?>
                </td>
                <?php if ($show_item_discounts) : ?>
                <td class="text-right">
                    <?php echo format_currency($item->item_discount); ?>
                </td>
                <?php endif; ?>
                <td class="text-right">
                    <?php echo format_currency($item->item_total); ?>
                </td>
            </tr>
            <?php } ?>

            </tbody>
            <tbody class="invoice-sums">

                <tr>
                    <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                        <?php _trans('subtotal'); ?>
                    </td>
                    <td class="text-right"><?php echo format_currency($invoice->invoice_item_subtotal); ?></td>
                </tr>

                <?php if ($invoice->invoice_item_tax_total > 0) { ?>
                <tr>
                    <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                        <?php _trans('item_tax'); ?>
                    </td>
                    <td class="text-right">
                        <?php echo format_currency($invoice->invoice_item_tax_total); ?>
                    </td>
                </tr>
                <?php } ?>

                <?php foreach ($invoice_tax_rates as $invoice_tax_rate) : ?>
                <tr>
                    <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                        <?php echo htmlsc($invoice_tax_rate->invoice_tax_rate_name) . ' (' . format_amount($invoice_tax_rate->invoice_tax_rate_percent) . '%)'; ?>
                    </td>
                    <td class="text-right">
                        <?php echo format_currency($invoice_tax_rate->invoice_tax_rate_amount); ?>
                    </td>
                </tr>
                <?php endforeach ?>

                <?php if ($invoice->invoice_discount_percent != '0.00') : ?>
                <tr>
                    <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                        <?php _trans('discount'); ?>
                    </td>
                    <td class="text-right">
                        <?php echo format_amount($invoice->invoice_discount_percent); ?>%
                    </td>
                </tr>
                <?php endif; ?>
                <?php if ($invoice->invoice_discount_amount != '0.00') : ?>
                <tr>
                    <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                        <?php _trans('discount'); ?>
                    </td>
                    <td class="text-right">
                        <?php echo format_currency($invoice->invoice_discount_amount); ?>
                    </td>
                </tr>
                <?php endif; ?>

                <tr>
                    <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                        <b><?php _trans('total'); ?></b>
                    </td>
                    <td class="text-right">
                        <b><?php echo format_currency($invoice->invoice_total); ?></b>
                    </td>
                </tr>
                <tr>
                    <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                        <?php _trans('paid'); ?>
                    </td>
                    <td class="text-right">
                        <?php echo format_currency($invoice->invoice_paid); ?>
                    </td>
                </tr>
                <tr>
                    <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                        <b><?php _trans('balance'); ?></b>
                    </td>
                    <td class="text-right">
                        <b><?php echo (format_currency($invoice->invoice_balance)); ?></b>
                    </td>
                </tr>
            </tbody>
        </table>


        <?php if ($invoice->invoice_terms) : ?>
        <div class="notes">
            <?php _trans('terms'); ?>:<br />
            <?php echo nl2br(($invoice->invoice_terms)); ?>
        </div>
        <?php endif; ?>
    </main>

</body>

</html>