<?php
$subscription = $this->home->get_subscription();
$my_subscribe = $this->home->get_my_subscription();
$my_subscribe_list = $this->home->get_my_subscription_list();
if (!empty($my_subscribe)) {
    $subscription_name = $this->db->where('id', $my_subscribe['subscription_id'])->get('subscription_fee')->row_array();
} else {
    $subscription_name['subscription_name'] = '';
}
?>

<div class="content">
    <div class="container">
        <div class="row">
            <?php $this->load->view('user/home/provider_sidemenu'); ?>
            <div class="col-xl-9 col-md-8">
                <?php
                if (!empty($my_subscribe['expiry_date_time'])) {
                    if (date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])) < date('Y-m-d')) {
                        ?>

                        <div class="alert alert-warning">
                            <div class="pricing-alert flex-wrap flex-md-nowrap">
                                <div class="alert-desc">
                                    <p class="mb-0"><?php echo (!empty($user_language[$user_selected]['lg_subscription_expired_on'])) ? $user_language[$user_selected]['lg_subscription_expired_on'] : $default_language['en']['lg_subscription_expired_on']; ?> <?php echo date('d-m-Y', strtotime($my_subscribe['expiry_date_time'])); ?>.</p>
                                </div>
                                <div class="alert-btn mt-3 mb-1 my-md-0">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-warning"><?php echo (!empty($user_language[$user_selected]['lg_Renew'])) ? $user_language[$user_selected]['lg_Renew'] : $default_language['en']['lg_Renew']; ?></a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                }
                ?>

                <?php
                if (!empty($my_subscribe['expiry_date_time'])) {
                    $before_days = date('Y-m-d', strtotime('-10 days', strtotime($my_subscribe['expiry_date_time'])));
                    $start = strtotime(date('Y-m-d'));
                    $end = strtotime($my_subscribe['expiry_date_time']);
                    $days = ceil(abs($end - $start) / 86400);

                    if (date('Y-m-d') >= $before_days && date('Y-m-d') <= $my_subscribe['expiry_date_time']) {
                        ?>
                        <div class="alert alert-info">
                            <?php if (!empty($days)) { ?> 
                                <?php echo (!empty($user_language[$user_selected]['lg_your_subscription_expires_on'])) ? $user_language[$user_selected]['lg_your_subscription_expires_on'] : $default_language['en']['lg_your_subscription_expires_on']; ?> <?= $days; ?> <?php echo (!empty($user_language[$user_selected]['lg_days'])) ? $user_language[$user_selected]['lg_days'] : $default_language['en']['lg_days']; ?>
                            <?php } else { ?>
                                <?php echo (!empty($user_language[$user_selected]['lg_Subscription_expired_today'])) ? $user_language[$user_selected]['lg_Subscription_expired_today'] : $default_language['en']['lg_Subscription_expired_today']; ?>
                        <?php } ?>
                        </div>
                    <?php }
                }
                ?>

                <div class="row pricing-box">
                    <?php foreach ($subscription as $list) { ?>
                        <?php
                        if (!empty($my_subscribe['subscription_id'])) {
                            if ($list['id'] == $my_subscribe['subscription_id']) {
                                if (date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])) >= date('Y-m-d')) {
                                    $class = "pricing-selected";
                                }
                            } else {
                                $class = '';
                            }
                        } else {
                            $class = '';
                        }
                        if (!isset($class)) {
                            $class = '';
                        }
                        
                            
                            $user_currency = get_provider_currency();
                            $user_currency_code = $user_currency['user_currency_code'];
                            $service_amount = get_gigs_currency($list['fee'], $list['currency_code'], $user_currency_code);
                            if (is_nan($service_amount) || is_infinite($service_amount)) {
                                $service_amount = $list['fee'];
                            }
                        ?>
                        <div class="col-xl-4 col-md-6 <?php echo $class; ?>">
                            <div class="card">
                                <div class="card-body">
                                    <div class="pricing-header">
                                        <h2><?php echo $list['subscription_name'] ?></h2>
                                        <p><?php echo (!empty($user_language[$user_selected]['lg_Monthly_Price'])) ? $user_language[$user_selected]['lg_Monthly_Price'] : $default_language['en']['lg_Monthly_Price']; ?></p>
                                    </div>              
                                    <div class="pricing-card-price">
                                        <h3 class="heading2 price"><?php echo currency_conversion($user_currency_code).$service_amount; ?></h3>
                                        <p><?php echo (!empty($user_language[$user_selected]['lg_Duration'])) ? $user_language[$user_selected]['lg_Duration'] : $default_language['en']['lg_Duration']; ?>: <span><?php echo $list['duration'] ?> <?php echo (!empty($user_language[$user_selected]['lg_Months'])) ? $user_language[$user_selected]['lg_Months'] : $default_language['en']['lg_Months']; ?></span></p>
                                    </div>
                                    <ul class="pricing-options">
                                        <li><i class="far fa-check-circle"></i> <?php echo (!empty($user_language[$user_selected]['lg_One_listing_submission'])) ? $user_language[$user_selected]['lg_One_listing_submission'] : $default_language['en']['lg_One_listing_submission']; ?></li>
                                        <li><i class="far fa-check-circle"></i> <?= $list['duration'] * 30; ?> <?php echo (!empty($user_language[$user_selected]['lg_days_expiration'])) ? $user_language[$user_selected]['lg_days_expiration'] : $default_language['en']['lg_days_expiration']; ?></li>
                                    </ul>
									
									<?php
									if ($list['id'] != $my_subscribe['subscription_id'] && $list['fee']>0) {
									?>
									
									 <div class="row m-2">
										<?php if(!empty($paypal_option_status)) { ?>
										<div class="col-6">
											<input class="form-check-input" type="radio" name="payment_type" id="paypal" value="paypal">
											<img src="<?= base_url() . "assets/img/paypal.png"; ?>">
										</div>
										<?php } if(!empty($stripe_option_status)) { ?>
										<div class="col-6">
											<input class="form-check-input" type="radio" name="payment_type" id="stripe"  value="stripe">
											<img src="<?= base_url() . "assets/img/stripe.png"; ?>">
										</div>
										<?php } if(!empty($razor_option_status)) { ?>
										<div class="col-6">
											<input class="form-check-input" type="radio" name="payment_type" id="razorpay"  value="razorpay">
											<img src="<?= base_url() . "assets/img/razorpay.png"; ?>">
										</div>
										<?php } ?>
									</div>


									<?php
									if($paypal_gateway=='sandbox')
									{
										$form_url='https://www.sandbox.paypal.com/cgi-bin/webscr';
									}
									else
									{
										$form_url='https://www.sandbox.paypal.com/cgi-bin/webscr';
									}
									?>
									
									
								<input type="hidden" id="razorpay_apikey" value="<?= $razorpay_apikey; ?>">

                              
                                <form name="frm_paypal_detail" id="frm_paypal_detail_<?=$list['id']?>" target="_blank" action="<?=$form_url?>" method="POST">
								
								<input type='hidden' name='business' value="<?= $user_details['email']; ?>">
								<input type='hidden' name='item_name' value='<?php echo $list['subscription_name'] ?>'> 
								<input type='hidden' name='item_number' value="123456"> 
								<input type='hidden' name='amount' value='<?=$service_amount?>'> 
							<input type='hidden' name='currency_code' value='<?php echo $user_details['currency_code'] ?>'>
							<!--<input type='hidden' name='notify_url' value='http://yourdomain.com/shopping-cart-check-out-flow-with-payment-integration/notify.php'>--> 
							<input type='hidden' name='return' value="<?=base_url() ?>user/subscription/paypal_payment/<?=$list["id"]?>">
							<input type="hidden" name="cmd" value="_xclick">  
							<input type="hidden" name="order" value="<?php echo $list['subscription_name'] ?>">
									<input type="hidden" id="paypal_gateway" value="<?= $paypal_gateway; ?>">
									<input type="hidden" id="braintree_key" value="<?= $braintree_key; ?>">
									
									<input type="hidden" id="razorpay_apikey" value="<?= $razorpay_apikey; ?>">

									<input type="hidden" id="username" value="<?= $user_details['name']; ?>">
									<input type="hidden" id="mobileno" value="<?= $user_details['mobileno']; ?>">


									<input type="hidden" id="state" value="<?= (!empty($state)) ? $state : "IL"; ?>">
									<input type="hidden" id="country" value="<?= (!empty($country)) ? $country : "US"; ?>">
									<input type="hidden" id="pincode" value="<?= (!empty($user_details['pincode'])) ? $user_details['pincode'] : "60652"; ?>">
									<input type="hidden" id="address" value="<?= (!empty($user_details['address'])) ? $user_details['address'] : "1234 Main St."; ?>"><input type="hidden" id="city" value="<?= (!empty($city)) ? $city : "Chicago"; ?>">

									<!--<div>
										<input type="submit" class="btn-action"
												name="continue_payment" value="Continue Payment">
									</div>-->
								</form>
                                <span class="paypal_desc"><?php echo (!empty($user_language[$user_selected]['lg_click_paypal_to_pay'])) ? $user_language[$user_selected]['lg_click_paypal_to_pay'] : $default_language['en']['lg_click_paypal_to_pay']; ?></span>
                                <a id="pays">
                                    <div id="paypal-button"></div>
                                </a>
                                    <?php } if (empty($subscription_name['subscription_name'])) { ?>
                                        <a href="javascript:void(0);" class="btn btn-primary btn-block callStripe" data-id="<?php echo $list['id']; ?>" data-curcon="<?php echo $list['fee']; ?>" data-amount="<?php echo $list['fee']; ?>" data-currency="<?php echo $list['currency_code']; ?>" ><?php echo (!empty($user_language[$user_selected]['lg_Select_Plan'])) ? $user_language[$user_selected]['lg_Select_Plan'] : $default_language['en']['lg_Select_Plan']; ?></a>
                                        <?php
                                    }
                                    if (!empty($my_subscribe['subscription_id'])) {

                                        if ($list['id'] == $my_subscribe['subscription_id'] && date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])) > date('Y-m-d')) {
                                            ?>
                                            <a href="javascript:void(0);" class="btn btn-primary btn-block"><?php echo (!empty($user_language[$user_selected]['lg_Subscribed'])) ? $user_language[$user_selected]['lg_Subscribed'] : $default_language['en']['lg_Subscribed']; ?></a>
                                            <?php
                                        } else {
                                            $subscription_fee = $this->db->where('id', $my_subscribe['subscription_id'])->get('subscription_fee')->row_array();
                                            if (!empty($subscription_fee)) {
                                                if ((int) $list['fee'] > (int) $subscription_fee['fee']) {
                                                    ?>

                                                    <a href="javascript:void(0);" class="btn btn-primary btn-block callStripe" data-id="<?php echo $list['id']; ?>" data-currency="<?php echo $user_currency_code; ?>" data-curcon="<?php echo $service_amount; ?>" data-amount="<?php echo $service_amount; ?>" ><?php echo (!empty($user_language[$user_selected]['lg_Select_Plan'])) ? $user_language[$user_selected]['lg_Select_Plan'] : $default_language['en']['lg_Select_Plan']; ?></a>

                                                    <?php
                                                } else {
                                                    if (date($my_subscribe['expiry_date_time']) >= date('Y-m-d')) {
                                                        ?>
                                                        <a data-toggle="tooltip" title="Your Not Choose This Plan ..!" href="javascript:void(0);"  class="btn btn-primary btn-block plan_notification" ><?php echo (!empty($user_language[$user_selected]['lg_Select_Plan'])) ? $user_language[$user_selected]['lg_Select_Plan'] : $default_language['en']['lg_Select_Plan']; ?></a>
                                                    <?php } else { ?>
                                                        <a href="javascript:void(0);" class="btn btn-primary btn-block callStripe" data-id="<?php echo $list['id']; ?>" data-currency="<?php echo $user_currency_code; ?>" data-curcon="<?php echo $service_amount; ?>" data-amount="<?php echo $service_amount; ?>" ><?php echo (!empty($user_language[$user_selected]['lg_Select_Plan'])) ? $user_language[$user_selected]['lg_Select_Plan'] : $default_language['en']['lg_Select_Plan']; ?></a>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                <?php } ?>
                </div>
<?php if (!empty($my_subscribe)) { 
$user_currency = get_provider_currency();
$user_currency_code = $user_currency['user_currency_code'];
$subscription_amount = get_gigs_currency($subscription_name['fee'], $subscription_name['currency_code'], $user_currency_code);

?>
                    <div class="card">
                        <div class="card-body">
                            <div class="plan-det">
                                <h6 class="title"><?php echo (!empty($user_language[$user_selected]['lg_Plan_Details'])) ? $user_language[$user_selected]['lg_Plan_Details'] : $default_language['en']['lg_Plan_Details']; ?></h6>
                                <ul class="row">
                                    <li class="col-sm-4">
                                        <p><span class="text-muted"><?php echo (!empty($user_language[$user_selected]['lg_Started_On'])) ? $user_language[$user_selected]['lg_Started_On'] : $default_language['en']['lg_Started_On']; ?></span> <?php
    if (!empty($my_subscribe['subscription_date'])) {
        echo date('d M Y', strtotime($my_subscribe['subscription_date']));
    }
    ?></p>
                                    </li>
                                    <li class="col-sm-4">
                                        <p><span class="text-muted"><?php echo (!empty($user_language[$user_selected]['lg_Price'])) ? $user_language[$user_selected]['lg_Price'] : $default_language['en']['lg_Price']; ?></span> <?php
    if (!empty($subscription_name['fee'])) {
        echo currency_conversion($user_currency_code).$subscription_amount;
    }
    ?></p>
                                    </li>
                                    <li class="col-sm-4">
                                        <p><span class="text-muted"><?php echo (!empty($user_language[$user_selected]['lg_Expired_On'])) ? $user_language[$user_selected]['lg_Expired_On'] : $default_language['en']['lg_Expired_On']; ?></span> <?php
                                        if (!empty($my_subscribe['expiry_date_time'])) {
                                            echo date('d M Y', strtotime($my_subscribe['expiry_date_time']));
                                        }
                                        ?> </p>
                                    </li>
                                </ul>
                                <h6 class="title"><?php echo (!empty($user_language[$user_selected]['lg_Last_Payment'])) ? $user_language[$user_selected]['lg_Last_Payment'] : $default_language['en']['lg_Last_Payment']; ?></h6>
                                <ul class="row">
                                    <li class="col-sm-4">
                                        <p><?php echo (!empty($user_language[$user_selected]['lg_Change_Plan'])) ? $user_language[$user_selected]['lg_Change_Plan'] : $default_language['en']['lg_Change_Plan']; ?> <?php
                                                if (!empty($my_subscribe['expiry_date_time'])) {
                                                    echo date('d M Y', strtotime($my_subscribe['subscription_date']));
                                                }
                                                ?></p>
                                    </li>
                                    <li class="col-sm-4">
                                        <p><span class="amount"><?php
                                                if (!empty($subscription_name['fee'])) {
                                                     echo currency_conversion($user_currency_code).$subscription_amount;
                                                }
                                                ?> </span> <span class="badge bg-success-light"><?php echo (!empty($user_language[$user_selected]['lg_Paid'])) ? $user_language[$user_selected]['lg_Paid'] : $default_language['en']['lg_Paid']; ?></span></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h5 class="mb-4"><?php echo (!empty($user_language[$user_selected]['lg_Subscribed_Details'])) ? $user_language[$user_selected]['lg_Subscribed_Details'] : $default_language['en']['lg_Subscribed_Details']; ?></h5>		
                    <div class="card transaction-table mb-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-center mb-0 no-footer">
                                    <thead>
                                        <tr>
                                            <th><?php echo (!empty($user_language[$user_selected]['lg_Plan'])) ? $user_language[$user_selected]['lg_Plan'] : $default_language['en']['lg_Plan']; ?></th>
                                            <th><?php echo (!empty($user_language[$user_selected]['lg_Start_Date'])) ? $user_language[$user_selected]['lg_Start_Date'] : $default_language['en']['lg_Start_Date']; ?></th>
                                            <th><?php echo (!empty($user_language[$user_selected]['lg_End_Date'])) ? $user_language[$user_selected]['lg_End_Date'] : $default_language['en']['lg_End_Date']; ?></th>
                                            <th><?php echo (!empty($user_language[$user_selected]['lg_Amount'])) ? $user_language[$user_selected]['lg_Amount'] : $default_language['en']['lg_Amount']; ?></th>
                                            <th><?php echo (!empty($user_language[$user_selected]['lg_Status'])) ? $user_language[$user_selected]['lg_Status'] : $default_language['en']['lg_Status']; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
    <?php foreach ($my_subscribe_list as $row) { ?>
                                            <tr role="row">
                                                <td><?= $row['subscription_name']; ?></td>
                                                <td><?= date('d-m-Y', strtotime($row['subscription_date'])); ?></td>
                                                <td><?= date('d-m-Y', strtotime($row['expiry_date_time'])); ?></td>
                                                <td><?= currency_conversion($user_currency_code).get_gigs_currency($row['fee'], $row['currency_code'], $user_currency_code); ?></td>
                                                <td><span class="badge bg-success-light"><?php echo (!empty($user_language[$user_selected]['lg_Paid'])) ? $user_language[$user_selected]['lg_Paid'] : $default_language['en']['lg_Paid']; ?></span></td> 
                                            </tr> 
    <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<?php } ?>
            </div>
        </div>
    </div>
</div>

<?php
$query = $this->db->query("select * from system_settings WHERE status = 1");
$result = $query->result_array();
$stripe_option = '1';
$publishable_key = '';
$live_publishable_key = '';
$logo_front = '';
foreach ($result as $res) {
    if ($res['key'] == 'stripe_option') {
        $stripe_option = $res['value'];
    }
    if ($res['key'] == 'publishable_key') {
        $publishable_key = $res['value'];
    }
    if ($res['key'] == 'live_publishable_key') {
        $live_publishable_key = $res['value'];
    }
    if ($res['key'] == 'logo_front') {
        $logo_front = $res['value'];
    }
}
if ($stripe_option == 1) {
    $stripe_key = $publishable_key;
} else {
    $stripe_key = $live_publishable_key;
}
if (file_exists($logo_front)) {
    $web_log = base_url() . $logo_front;
} else {
    $web_log = base_url() . 'assets/img/logo.png';
}
?>
<input type="hidden" id="stripe_key" value="<?= $stripe_key; ?>">
<input type="hidden" id="logo_front" value="<?= $web_log; ?>">


<button id="my_stripe_payyment"><?php echo (!empty($user_language[$user_selected]['lg_Purchase'])) ? $user_language[$user_selected]['lg_Purchase'] : $default_language['en']['lg_Purchase']; ?></button>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
