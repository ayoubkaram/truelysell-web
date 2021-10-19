<div class="content">
    <div class="container">
        <div class="row">
            <?php $this->load->view('user/home/provider_sidemenu'); ?>
            <div class="col-xl-9 col-md-8">
                <h4 class="widget-title"><?php echo (!empty($user_language[$user_selected]['lg_My_Services'])) ? $user_language[$user_selected]['lg_My_Services'] : $default_language['en']['lg_My_Services']; ?></h4>
                <ul class="nav nav-tabs menu-tabs">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo base_url() ?>my-services"><?php echo (!empty($user_language[$user_selected]['lg_Active_Services'])) ? $user_language[$user_selected]['lg_Active_Services'] : $default_language['en']['lg_Active_Services']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url() ?>my-services-inactive"><?php echo (!empty($user_language[$user_selected]['lg_Inactive_Services'])) ? $user_language[$user_selected]['lg_Inactive_Services'] : $default_language['en']['lg_Inactive_Services']; ?></a>
                    </li>
                </ul>
                <div class="row" id="dataList">

                    <?php
                    $this->session->flashdata('success_message');
                    if (!empty($services)) {
                        foreach ($services as $srows) {
                            $mobile_image = explode(',', $srows['mobile_image']);
                            $this->db->select("service_image");
                            $this->db->from('services_image');
                            $this->db->where("service_id", $srows['id']);
                            $this->db->where("status", 1);
                            $image = $this->db->get()->row_array();
                            $this->db->select('AVG(rating)');
                            $this->db->where(array('service_id' => $srows['id'], 'status' => 1));
                            $this->db->from('rating_review');
                            $rating = $this->db->get()->row_array();
                            $avg_rating = round($rating['AVG(rating)'], 1);
                            $provider_details = $this->db->where('id', $srows['user_id'])->get('providers')->row_array();
                            $service_availability = $this->db->where('service_id', $srows['id'])->where('status!=', 6)->where('status!=', 7)->from('book_service')->count_all_results();


                            $user_currency_code = '';
                            $userId = $this->session->userdata('id');
                            If (!empty($userId)) {
                                $service_amount = $srows['service_amount'];
                                $user_currency = get_provider_currency();
                                $user_currency_code = $user_currency['user_currency_code'];

                                $service_amount = get_gigs_currency($srows['service_amount'], $srows['currency_code'], $user_currency_code);
                            } else {
                                $user_currency_code = settings('currency');
                                $service_amount = $srows['service_amount'];
                            }
                            if (is_nan($service_amount) || is_infinite($service_amount)) {
                                $service_amount = $srows['service_amount'];
                            }
                            ?>

                            <div class="col-lg-4 col-md-6">
                                <div class="service-widget">
                                    <div class="service-img"> 
                                        <a href="<?php echo base_url() . 'service-preview/' . str_replace(' ', '-', $srows['service_title']) . '?sid=' . md5($srows['id']); ?>">
                                        <?php if ($image['service_image'] != '' && (@getimagesize(base_url().$image['service_image']))) { ?>
                                            <img class="img-fluid serv-img" alt="Service Image" src="<?php echo base_url() . $image['service_image']; ?>">
										<?php } else { ?>
											 <img class="img-fluid serv-img" alt="Service Image" src="https://via.placeholder.com/360x220.png?text=Service%20Image">
										<?php } ?>    
                                        </a>
                                        <div class="item-info">
                                            <div class="service-user">
                                                <a href="javascript:void(0);">
                                                    <?php if (file_exists($provider_details['profile_img'])) { ?>
                                                        <img src="<?php echo base_url() . $provider_details['profile_img'] ?>">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>assets/img/user.jpg">
                                                    <?php } ?>
                                                </a>
                                                <span class="service-price"><?php echo currency_conversion($user_currency_code) . $service_amount; ?></span>
                                            </div>
                                            <div class="cate-list">
                                                <a class="bg-yellow" href="<?php echo base_url() . 'search/' . str_replace(' ', '-', strtolower($srows['category_name'])); ?>"><?php echo $srows['category_name']; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="service-content">
                                        <h3 class="title">
                                            <a href="<?php echo base_url() . 'service-preview/' . str_replace(' ', '-', $srows['service_title']) . '?sid=' . md5($srows['id']); ?>"><?php echo $srows['service_title']; ?></a>
                                        </h3>
                                        <div class="rating">

                                            <?php
                                            for ($x = 1; $x <= $avg_rating; $x++) {
                                                echo '<i class="fas fa-star filled"></i>';
                                            }
                                            if (strpos($avg_rating, '.')) {
                                                echo '<i class="fas fa-star"></i>';
                                                $x++;
                                            }
                                            while ($x <= 5) {
                                                echo '<i class="fas fa-star"></i>';
                                                $x++;
                                            }
                                            ?>
                                            <span class="d-inline-block average-rating">(<?php echo $avg_rating ?>)</span>
                                        </div>
                                        <div class="user-info">
                                            <div class="row">
                                                <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                                <span class="col ser-location"><span><?php echo $srows['service_location']; ?></span> <i class="fas fa-map-marker-alt ml-1"></i></span>
                                            </div>
                                            <div class="service-action">
                                                <div class="row">
                                                    <div class="col"><a href="<?php echo base_url() ?>user/service/edit_service/<?php echo $srows['id'] ?>" class="text-success"><i class="far fa-edit"></i> <?php echo (!empty($user_language[$user_selected]['lg_Edit'])) ? $user_language[$user_selected]['lg_Edit'] : $default_language['en']['lg_Edit']; ?></a></div>
                                                    <?php if ($service_availability == 0) { ?>

                                                        <div class="col text-right"><a href="javascript:void(0);" class="si-delete-service text-danger" data-id="<?php echo $srows['id']; ?>"><i class="fas fa-info-circle"></i> <?php echo (!empty($user_language[$user_selected]['lg_Inactive'])) ? $user_language[$user_selected]['lg_Inactive'] : $default_language['en']['lg_Inactive']; ?></a></div>
                                                    <?php } else { ?>
                                                        <div class="col text-right"><a href="javascript:void(0);" class="text-danger" data-toggle="modal" data-target="#deleteNotConfirmModal"><i class="far fa-trash-alt"></i> <?php echo (!empty($user_language[$user_selected]['lg_Inactive'])) ? $user_language[$user_selected]['lg_Inactive'] : $default_language['en']['lg_Inactive']; ?></a></div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>											
                                    </div>
                                </div>								
                            </div>
                            <?php
                        }
                    } else { ?>
                        <div class="col-xl-12 col-lg-12"><?php echo (!empty($user_language[$user_selected]['lg_no_service'])) ? $user_language[$user_selected]['lg_no_service'] : $default_language['en']['lg_no_service']; ?></div>
                    <?php }
                    ?>

                    <!-- Pagination Links -->
                    <?php
                    if (!empty($services)) {
                        echo $this->ajax_pagination->create_links();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="acc_title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="acc_msg"></p>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-success si_accept_confirm"><?php echo (!empty($user_language[$user_selected]['lg_Yes'])) ? $user_language[$user_selected]['lg_Yes'] : $default_language['en']['lg_Yes']; ?></a>
                <button type="button" class="btn btn-danger si_accept_cancel" data-dismiss="modal"><?php echo (!empty($user_language[$user_selected]['lg_Cancel'])) ? $user_language[$user_selected]['lg_Cancel'] : $default_language['en']['lg_Cancel']; ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteNotConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="acc_title"><?php echo (!empty($user_language[$user_selected]['lg_Inactive_Service'])) ? $user_language[$user_selected]['lg_Inactive_Service'] : $default_language['en']['lg_Inactive_Service']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="acc_msg"><?php echo (!empty($user_language[$user_selected]['lg_Service_Booked_Inprogress'])) ? $user_language[$user_selected]['lg_Service_Booked_Inprogress'] : $default_language['en']['lg_Service_Booked_Inprogress']; ?></p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-danger si_accept_cancel" data-dismiss="modal"><?php echo (!empty($user_language[$user_selected]['lg_Ok'])) ? $user_language[$user_selected]['lg_Ok'] : $default_language['en']['lg_Ok']; ?></button>
            </div>
        </div>
    </div>
</div>
