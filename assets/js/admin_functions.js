(function($) {
	"use strict";
	
	var csrf_token=$('#admin_csrf').val();
	var base_url=$('#base_url').val();
	var page=$('#page').val();
	var provider_list_url=$('#provider_list_url').val();
	var requests_list_url=$('#requests_list_url').val();
	var user_list_url=$('#user_list_url').val();
	var adminuser_list_url=$('#adminuser_list_url').val();//alert(adminuser_list_url);
	
	$('.example1').checkboxall();
	
	$( document ).ready(function() {
        var login_type= $("input[name='login_type']:checked").val(); 
        //var login_type= $('input[type=radio][name=login_type].checked').val();
        if(login_type=="mobile"){
           $('#otpbydiv').show();
       	} else {
			$('#otpbydiv').hide();
			//$('.otp_by').prop('checked', false);
       	}

	$('#img_upload_error').hide();
	$('#img_upload_errors').hide();
	setTimeout(function(){ $('#flash_success_message').hide(); }, 5000);
	setTimeout(function(){ $('#flash_succ_message').hide(); }, 5000);
	setTimeout(function(){ $('#flash_error_message').hide(); }, 5000);
	$('.change_Status_Service').on('click',function(){
		var id=$(this).attr('data-id');
      change_Status_Service(id);
	});
     $('.delete_review_comment').on('click',function(){
		var id=$(this).attr('data-id');
      delete_review_comment(id);
    }); 
    $('.change_Status_rating').on('click',function(){
		var id=$(this).attr('data-id');
      change_Status_rating(id);
    }); $('.delete_service_provider').on('click',function(){
		var id=$(this).attr('data-id');
      delete_service_provider(id);
    }); 
    $('.update_language').on('click',function(){
		var lang_key=$(this).attr('data-lang-key');
		var lang=$(this).attr('data-lang');
		var page=$(this).attr('data-page');
      update_language(lang_key,lang,page);
    }); 
     $('#reject_payment_submit').on('submit',function(){
     var result=reject_payment_submit();
     return result;
    }); 	

});




	var account_holder_name = '';
	var account_number = '';
	var account_iban = '';
	var bank_name = '';
	var bank_address = '';
	var sort_code = '';
	var routing_number = '';
	var account_ifsc = '';
	var transaction_id = '';
	var booking_id = '';


	/*service list Active And De Active*/
	function change_Status_Service(service_id){
		var stat= $('#status_'+service_id).prop('checked');
		if(stat==true) {
			var status=1;
		}
		else {
			var status=0;
		}
		$.post(base_url+'admin/service/change_Status_service_list',{id:service_id,status:status,csrf_token_name:csrf_token},function(data){
			if(data==1){
				alert("Sorry That Service Was Booked Some One\n So You Can't Inactive The Service");
				$(".check_status").attr('checked', $(this).attr('checked'));
				$('#status_'+service_id).attr('data-on',"Active");
				$('.check_status').addClass('toggle-on');
			}
			console.log(data);
			if(data=="success"){
				 swal({
         title: "Service",
         text: "Service Status Change SuccessFully....!",
         icon: "success",
         button: "okay",
         closeOnEsc: false,
         closeOnClickOutside: false
       });
			}
			
		});
	}
	
	$('#admin_payment').bootstrapValidator({
		fields: {
			transaction_id: {
				validators: {
					
					notEmpty: {
						message: 'Please enter transaction ID'
					}
				}
			}            
		}
	}).on('success.form.bv', function(e) {
		e.preventDefault();
		var	account_holder_name = $("#account_holder_name").val();
		var	account_number = $("#account_number").val();
		var	account_iban = $("#account_iban").val();
		var	bank_name = $("#bank_name").val();
		var	bank_address = $("#bank_address").val();
		var	sort_code = $("#sort_code").val();
		var	routing_number = $("#routing_number").val();
		var	account_ifsc = $("#account_ifsc").val();
		var	transaction_id = $("#transaction_id").val();
		var	booking_id = $("#booking_id").val();
		$.ajax({
			url: base_url+'admin/payments/add_payment/',
			data: {csrf_token_name:csrf_token,account_holder_name:account_holder_name,account_number:account_number,account_iban:account_iban,bank_name:bank_name,bank_address:bank_address,sort_code:sort_code,routing_number:routing_number,account_ifsc:account_ifsc,transaction_id:transaction_id,booking_id:booking_id},
			type: 'POST',
			dataType: 'JSON',
			success: function(response){
				window.location.href = base_url+'payment_list';
			},
			error: function(error){
				console.log(error);
			}
		});
	});    
var timeout = 3000; // in miliseconds (3*1000)
$('#flash_succ_message').delay(timeout).fadeOut(500);
$('#flash_error_message').delay(timeout).fadeOut(500);

/*if($('#world-map-markers').length > 0 ){
	var map_list=[];
	$.ajax({
		url: base_url+'map_lists',
		data: {'tets':'test','csrf_token_name':csrf_token},
		type: 'POST',
		dataType: 'JSON',
		success: function(response){
			map_list=response;
			$('#world-map-markers').vectorMap({
				map: 'world_mill',
				scaleColors: ['#C8EEFF', '#0071A4'],
				normalizeFunction: 'polynomial',
				hoverOpacity: 1,
				hoverColor: false,
				markerStyle: {
					initial: {
						fill: '#ff0080',
						stroke: '#ff0080'
					}
				},
				regionStyle: {
					initial: {
						fill: '#ccc'
					},
					selected: {
						fill: '#ccc'
					}
				},
				backgroundColor: '#ffffff',
				markers:map_list
			});
		}
	})
}*/

if($('#world-map-markers').length > 0 ){
	var map_list=[];
	$.ajax({
		url: base_url+'map_lists',
		data: {'tets':'test','csrf_token_name':csrf_token},
		type: 'POST',
		dataType: 'JSON',
		success: function(response){
			map_list=response;console.log(map_list.length);
			var center = new google.maps.LatLng(37.9643, -91.8318);

			var map = new google.maps.Map(document.getElementById('map'), {
			  zoom: 3,
			  center: center,
			  mapTypeId: google.maps.MapTypeId.ROADMAP
			});

			var markers = [];
			for (var i = 0; i < map_list.length; i++) {
				var lat_long_val = map_list[i].latLng;
				var lat_long_val_spilt = lat_long_val.toString().split(',');
			  var latLngval = new google.maps.LatLng(lat_long_val_spilt[0],lat_long_val_spilt[1]);
			  var marker = new google.maps.Marker({
				position: latLngval
			  });
			  markers.push(marker);
			}
			var markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
			/*$('#world-map-markers').vectorMap({
				map: 'world_mill',
				scaleColors: ['#C8EEFF', '#0071A4'],
				normalizeFunction: 'polynomial',
				hoverOpacity: 1,
				hoverColor: false,
				markerStyle: {
					initial: {
						fill: '#ff0080',
						stroke: '#ff0080'
					}
				},
				regionStyle: {
					initial: {
						fill: '#ccc'
					},
					selected: {
						fill: '#ccc'
					}
				},
				backgroundColor: '#ffffff',
				markers:map_list
			});*/
		}
	})
}


if(page == 'service-providers' ||page == 'stripe_payment_gateway' || page == 'service-list' ||page == 'users'||page == 'provider_list' ||page == 'provider-details'){ 

	var providers_table = $('#providers_table').on('init.dt', function () {
	} ).DataTable({
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			"ordering": false,
			"ajax": {
				"url":provider_list_url,
				"type": "POST",
				"data": {csrf_token_name:csrf_token},
			},
			"columnDefs": [
			{
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ]
	});
	
	$('#providers_table').on('click','.delete_provider_data', function () {
		console.log("3");
	  	var id = $(this).attr('data-id');
	  	delete_provider_data(id);
	});	
	
	$('#providers_table').on('click','.change_Status_provider1', function () {
	var id = $(this).attr('data-id');
	change_Status_provider1(id);
	});
}

$('.service_table').on('click','.change_Status_provider', function () {
	var id = $(this).attr('data-id');
	change_Status_provider1(id);
	});

if(page == 'service-requests'){
	
		requests_table = $('#requests_table').DataTable({
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			"ajax": {
				"url":requests_list_url,
				"type": "POST",
				"data": function ( data ) {}
			},
			"columnDefs": [
			{
			"targets": [ 7 ], //first column / numbering column
			"orderable": false, //set not orderable
		},
		],
	});

}

	if(page == 'users'){
	
		var users_table = $('#users_table').DataTable({
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			"ordering": false,
			"ajax": {
				"url":user_list_url,
				"type": "POST",

				"data":{csrf_token_name:csrf_token}
			},
			"columnDefs": [
			{
				"targets": [ 0 ], //first column / numbering column
				"orderable": false, //set not orderable
			},
			]
		});
		$('#users_table').on('click','.change_Status_user1', function () {
			console.log("3");
  			var id = $(this).attr('data-id');
  			change_Status_user1(id);
		});

		$('#users_table').on('click','.delete_user_data', function () {
			console.log("3");
	  		var id = $(this).attr('data-id');
	  		delete_user_data(id);
		});	

	}





function reject_payment_submit(){
	var type=true;
	var r = confirm("Are you Sure About This process");
	if (r == true) {
		type=true;
	} else {
		type=false;
	}
	return type;
}

var successClick = function(){
	$.notify({
		title: '<strong>Success</strong>',
		message: "<br>"+success_message,
		icon: 'glyphicon glyphicon-ok',
		target: '_blank'
	},{
		element: 'body',
		type: "success",
		showProgressbar: false,
		placement: {
			from: "top",
			align: "right"
		},
		offset: 20,
		spacing: 10,
		z_index: 1031,
		delay: 3300,
		timer: 1000,
		mouse_over: null,
		animate: {
			enter: 'animated fadeInDown',
			exit: 'animated fadeOutRight'
		},
		onShow: null,
		onShown: null,
		onClose: null,
		onClosed: null,
		icon_type: 'class',
	});
}

var infoClick = function(){
	$.notify({
		title: '<strong>Info</strong>',
		message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
		icon: 'glyphicon glyphicon-info-sign',
	},{
		element: 'body',
		position: null,
		type: "info",
		allow_dismiss: true,
		newest_on_top: false,
		showProgressbar: false,
		placement: {
			from: "top",
			align: "right"
		},
		offset: 20,
		spacing: 10,
		z_index: 1031,
		delay: 3300,
		timer: 1000,
		mouse_over: null,
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		onShow: null,
		onShown: null,
		onClose: null,
		onClosed: null,
		icon_type: 'class',
	});
}

var warningClick = function(){
	$.notify({
		title: '<strong>Warning</strong>',
		message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
		icon: 'glyphicon glyphicon-warning-sign',
	},{
		element: 'body',
		position: null,
		type: "warning",
		allow_dismiss: true,
		newest_on_top: false,
		showProgressbar: false,
		placement: {
			from: "top",
			align: "right"
		},
		offset: 20,
		spacing: 10,
		z_index: 1031,
		delay: 3300,
		timer: 1000,
		mouse_over: null,
		animate: {
			enter: 'animated bounceIn',
			exit: 'animated bounceOut'
		},
		onShow: null,
		onShown: null,
		onClose: null,
		onClosed: null,
		icon_type: 'class',
	});
}

var dangerClick = function(){
	$.notify({
		title: '<strong>Danger</strong>',
		message: "<br>"+error_message,
		icon: 'glyphicon glyphicon-remove-sign',
	},{
		element: 'body',
		position: null,
		type: "danger",
		allow_dismiss: true,
		newest_on_top: false,
		showProgressbar: false,
		placement: {
			from: "top",
			align: "right"
		},
		offset: 20,
		spacing: 10,
		z_index: 1031,
		delay: 3300,
		timer: 1000,
		mouse_over: null,
		animate: {
			enter: 'animated flipInY',
			exit: 'animated flipOutX'
		},
		onShow: null,
		onShown: null,
		onClose: null,
		onClosed: null,
		icon_type: 'class',
	});
}

var primaryClick = function(){
	$.notify({
		title: '<strong>Primary</strong>',
		message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
		icon: 'glyphicon glyphicon-ruble',
	},{
		element: 'body',
		position: null,
		type: "success",
		allow_dismiss: true,
		newest_on_top: false,
		showProgressbar: false,
		placement: {
			from: "top",
			align: "right"
		},
		offset: 20,
		spacing: 10,
		z_index: 1031,
		delay: 3300,
		timer: 1000,
		mouse_over: null,
		animate: {
			enter: 'animated lightSpeedIn',
			exit: 'animated lightSpeedOut'
		},
		onShow: null,
		onShown: null,
		onClose: null,
		onClosed: null,
		icon_type: 'class',
	});
}

var defaultClick = function(){
	$.notify({
		title: '<strong>Default</strong>',
		message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
		icon: 'glyphicon glyphicon-ok-circle',
	},{
		element: 'body',
		position: null,
		type: "warning",
		allow_dismiss: true,
		newest_on_top: false,
		showProgressbar: false,
		placement: {
			from: "top",
			align: "right"
		},
		offset: 20,
		spacing: 10,
		z_index: 1031,
		delay: 3300,
		timer: 1000,
		mouse_over: null,
		animate: {
			enter: 'animated rollIn',
			exit: 'animated rollOut'
		},
		onShow: null,
		onShown: null,
		onClose: null,
		onClosed: null,
		icon_type: 'class',
	});
}

var linkClick = function(){
	$.notify({
		title: '<strong>Link</strong>',
		message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
		icon: 'glyphicon glyphicon-search',
	},{
		element: 'body',
		position: null,
		type: "danger",
		allow_dismiss: true,
		newest_on_top: false,
		showProgressbar: false,
		placement: {
			from: "top",
			align: "right"
		},
		offset: 20,
		spacing: 10,
		z_index: 1031,
		delay: 3300,
		timer: 1000,
		mouse_over: null,
		animate: {
			enter: 'animated zoomInDown',
			exit: 'animated zoomOutUp'
		},
		onShow: null,
		onShown: null,
		onClose: null,
		onClosed: null,
		icon_type: 'class',
	});
}
function change_Status_rating(id) { 
	var stat= $('#status_'+id).prop('checked');
	if(stat==true) {
		var status=1;
	}
	else {
		var status=0;
	}
	$.post(base_url+'admin/dashboard/change_rating',{id:id,status:status,csrf_token_name:csrf_token},function(data){
		 swal({
         title: "Rating",
         text: "Rating Status Change SuccessFully....!",
         icon: "success",
         button: "okay",
         closeOnEsc: false,
         closeOnClickOutside: false
       });
	});
}
function change_Status_subcategory(id) {
	var stat= $('#status_'+id).prop('checked');
	if(stat==true) {
		var status=1;
	}
	else {
		var status=2;
	}
	$.post(base_url+'admin/dashboard/change_subcategory',{id:id,status:status},function(data){
		console.log(data);
	});
}

function change_Status_category(id) {
	var stat= $('#status_'+id).prop('checked');
	if(stat==true) {
		var status=1;
	}
	else {
		var status=2;
	}
	$.post(base_url+'admin/dashboard/change_category',{id:id,status:status},function(data){
		console.log(data);
	});
}

function change_Status_users(id) {
	var stat= $('#status_'+id).prop('checked');
	if(stat==true) {
		var status=1;
	}
	else {
		var status=2;
	}
	$.post(base_url+'admin/dashboard/change_Statuss',{id:id,status:status},function(data){
		console.log(data);
	});
}





function delete_review_comment(id) {
	if(confirm("Are you sure you want to delete this Comment...!?")){
		$.post(base_url+'admin/Ratingstype/delete_comment',{id:id,csrf_token_name:csrf_token},function(result){
			if(result) {
				window.location.reload();
			}
		});
	}   
}  

function delete_service_provider(id) {
	if(confirm("Are you sure you want to delete this provider?")){
		$.post(base_url+'admin/service/delete_provider',{id:id},function(result){
			if(result) {
				window.location.reload();
			}
		});
	}   
}  
function delete_service(id) {
	$('#delete_service').modal('show');
	$('#service_id').val(id);
}
   

   function delete_user_data(val) 
   {	   
	   //var r = confirm("Deleting user will also delete its related all datas!! ");
		swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				var url = base_url + 'admin/dashboard/delete_user_data';
			  	var user_id = val;
			  	var data = { 
					user_id: user_id,
					csrf_token_name:csrf_token
				};
				 
			 	$.ajax({
					url: url,
					data: data,
					type: "POST",
					dataType: 'json',
					success: function (response) { 
					  if (response.status) { 
						swal({
							title: "Success",
							text: response.msg,
							icon: "success",
							button: "okay",
							closeOnEsc: false,
							closeOnClickOutside: false
						}).then(function(){ 
							window.location.href=base_url+'users';
						});
					  } else {
						swal({
							title: "Error",
							text: response.msg,
							icon: "error",
							button: "okay",
							closeOnEsc: false,
							closeOnClickOutside: false
						}).then(function(){ 
							location.reload();
						});
					  }
					}
				});
			} else {
				return false;
			}
		});
	}
   
   function delete_provider_data(val) {
	   
	   //var r = confirm("Deleting provider will also delete its related all datas!! ");
	   swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
		  		var url = base_url + 'admin/service/delete_provider_data';
			  	var user_id = val;
			  	var data = { 
					user_id: user_id,
					csrf_token_name:csrf_token
				};
			 	$.ajax({
					url: url,
					data: data,
					type: "POST",
					dataType: 'json',
					success: function (response) { 
					  if (response.status) { 
						swal({
							title: "Success",
							text: response.msg,
							icon: "success",
							button: "okay",
							closeOnEsc: false,
							closeOnClickOutside: false
						}).then(function(){ 
							window.location.href=base_url+'service-providers';
						});
					  } else {
						swal({
							title: "Error",
							text: response.msg,
							icon: "error",
							button: "okay",
							closeOnEsc: false,
							closeOnClickOutside: false
						}).then(function(){ 
							location.reload();
						});
					  }
					}
				});
			} else {
				return false;
			}
		});
	}

function change_Status_user1(service_id){
	var stat= $('#status_'+service_id).prop('checked');
	if(stat==true) {
		var status=1;
	}
	else {
		var status=2;
	}
var url = base_url+ 'admin/dashboard/delete_users';
var category_id = service_id;
var data = { 
  user_id: category_id,
  status: status,
  csrf_token_name:csrf_token
};
$.ajax({
  url: url,
  data: data,
  type: "POST",
  success: function (data) {
	if(data==1){
			alert("Failed to change Status");
			$(".check_status").attr('checked', $(this).attr('checked'));
			$('#status_'+service_id).attr('data-on',"Active");
			$('.check_status').addClass('toggle-on');
		}
		console.log(data);
		if(data=="success"){
			 swal({
	 title: "User",
	 text: "User Status Change SuccessFully....!",
	 icon: "success",
	 button: "okay",
	 closeOnEsc: false,
	 closeOnClickOutside: false
   });
		}
  }
});
}

function change_Status_provider1(service_id){
	var stat= $('#status_'+service_id).prop('checked');
	if(stat==true) {
		var status=1;
	}
	else {
		var status=2;
	}
var url = base_url+ 'admin/dashboard/delete_provider';
var category_id = service_id;
var data = { 
  provider_id: category_id,
  status: status,
  csrf_token_name:csrf_token
};
$.ajax({
  url: url,
  data: data,
  type: "POST",
  success: function (data) {
	if(data==1){
			alert("Failed to change Status");
			$(".check_status").attr('checked', $(this).attr('checked'));
			$('#status_'+service_id).attr('data-on',"Active");
			$('.check_status').addClass('toggle-on');
		}
		console.log(data);
		if(data=="success"){
			 swal({
	 title: "Provider",
	 text: "Provider Status Change SuccessFully....!",
	 icon: "success",
	 button: "okay",
	 closeOnEsc: false,
	 closeOnClickOutside: false
   });
		}
  }
});
}


if(page == 'service-providers' || page== 'users' ||page == 'stripe_payment_gateway' || page == 'service-list' ||page == 'users'||page == 'provider_list' ||page == 'provider-details'){ 

	/*service list Active And De Active*/
	function change_Status_Service(service_id){
		var stat= $('#status_'+service_id).prop('checked');
		if(stat==true) {
			var status=1;
		}
		else {
			var status=0;
		}
		$.post(base_url+'admin/service/change_Status_service_list',{id:service_id,status:status,csrf_token_name:csrf_token},function(data){
			if(data==1){
				alert("Sorry That Service Was Booked Some One\n So You Can't Inactive The Service");
				$(".check_status").attr('checked', $(this).attr('checked'));
				$('#status_'+service_id).attr('data-on',"Active");
				$('.check_status').addClass('toggle-on');
			}
			console.log(data);
			if(data=="success"){
				 swal({
         title: "Service",
         text: "Service Status Change SuccessFully....!",
         icon: "success",
         button: "okay",
         closeOnEsc: false,
         closeOnClickOutside: false
       });
			}
			
		});
	}

	function change_Status(id) {
		var stat= $('#status_'+id).prop('checked');
		if(stat==true) {
			var status=1;
		}
		else {
			var status=0;
		}
		$.post(base_url+'admin/service/change_Status',{id:id,status:status},function(data){
		});
	}
}

 $( document ).ready(function() {
       $('.meta_google').hide();
       $('.meta_twitter').hide();
            //var mail_config=$('#mail_config').val();

           
            $('input[type=radio][name=social_meta]').on('change',function() {
			//	alert('hjhjj');
           var social_meta=$(this).val();
           if(social_meta=="meta_google"){
            $('.meta_google').show();
            $('.meta_fb').hide();
            $('.meta_twitter').hide();
           }else if(social_meta=='meta_twitter')
		   {
			    $('.meta_fb').hide();
                $('.meta_google').hide();
                $('.meta_twitter').show();
		   }
		   else{
                $('.meta_fb').show();
                $('.meta_google').hide();
                $('.meta_twitter').hide();
           }
        });
    });
	
	
	 $('input[type=radio][name=login_type]').on('change',function() {
			//	alert('hjhjj');
           var login_type=$(this).val();
           if(login_type=="mobile"){
            $('#otpbydiv').show();
           }
		   else{
			$('#otpbydiv').hide();
			//$('.otp_by').val('');
			$('.otp_by').prop('checked', false);

           }
        });
		
	$( document ).ready(function() {
		$('.razorpay_stripe_payment').on('change',function(){
			var id=$(this).val();//alert(id);
		  razor_payment(id);
		});
	});
	function razor_payment(value) {
		if(value!=''){
			$.ajax({
				type: "post",
				url: base_url+"admin/settings/razor_payment_type",
				data:{type:value,'csrf_token_name':csrf_token}, 
				dataType:'json',
				success: function (data) {
					if(data!=''){
						$('#gateway_name').val(data.gateway_name);
						$('#api_key').val(data.api_key);
						$('#value').val(data.api_secret);
					}
				}
			});		
		}
	}

$( document ).ready(function() {
	$('.paypal_payment').on('change',function(){
			var id=$(this).val();//alert('hihihi');
		  paypal_payment(id);
		});
	});
	function paypal_payment(value) {
		if(value!=''){
			$.ajax({
				type: "post",
				url: base_url+"admin/settings/paypal_payment_type",
				data:{type:value,'csrf_token_name':csrf_token}, 
				dataType:'json',
				success: function (data) {
					if(data!=''){
						$('#braintree_key').val(data.braintree_key);
						$('#braintree_merchant').val(data.braintree_merchant);
						$('#braintree_publickey').val(data.braintree_publickey);
						$('#braintree_privatekey').val(data.braintree_privatekey);
						$('#paypal_appid').val(data.paypal_appid);
						$('#paypal_appkey').val(data.paypal_appkey);
					}
				}
			});		
		}
	}	
	
	if(page == 'adminusers'){
	
	var users_table = $('#adminusers_table').DataTable({
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			"ordering": false,
			"ajax": {
				"url":adminuser_list_url,
				"type": "POST",

				"data":{csrf_token_name:csrf_token}
			},
			"columnDefs": [
			{
			"targets": [ 0 ], //first column / numbering column
			"orderable": false, //set not orderable
		},
		]
	});
	
}

//AdminUser form validation
$('#add_adminuser').bootstrapValidator({
	fields: {
		username:   {
			validators: {
				remote: {
					url: base_url + 'admin/dashboard/check_adminuser_name',
					data: function(validator) {
						return {
							name: validator.getFieldElements('username').val(),
							csrf_token_name:csrf_token,
							id:$('#user_id').val()
						};
					},
					message: 'User Name is already exist',
					type: 'POST'
				},
				notEmpty: {
					message: 'User Name is Required'

				}
			}
		},
		email:           {
			validators: {
				remote: {
					url: base_url + 'admin/dashboard/check_adminuser_email',
					data: function(validator) {
						return {
							name: validator.getFieldElements('email').val(),
							csrf_token_name:csrf_token,
							id:$('#user_id').val()
						};
					},
					message: 'Email is already exist',
					type: 'POST'
				},
				notEmpty: {
					message: 'Email is Required'

				}
			}
		},
		full_name:           {
			validators: {
				notEmpty: {
					message: 'Full Name is Required'

				}
			}
		},
		/*selectall1:           {
		   validators:           {
			notEmpty: {
					message: 'Access is Required'

				}
		  }
		},*/
		profile_img:           {
		   validators:           {
			file: {
			  extension: 'jpeg,png,jpg,gif',
			  type: 'image/jpeg,image/png,image/jpg,image/gif',
			  message: 'The selected file is not valid. Only allowed jpeg,jpg,png,gif files'
			}
		  }
		},
	}
}).on('success.form.bv', function(e) {
	var formData = new FormData(document.getElementById('add_adminuser'));
	$.ajax({
		type:'POST',
		url: base_url+'admin/dashboard/update_adminuser',
		enctype: 'multipart/form-data',
		data: formData,
		cache: false,						
		contentType: false,
		dataType: 'json',
		processData: false,
		success:function(response)
		{
			//console.log(response);return false;
			if(response.status)
			{
				swal({
					title: "Success",
					text: response.msg,
					icon: "success",
					button: "okay",
					closeOnEsc: false,
					closeOnClickOutside: false
				}).then(function(){ 
					window.location.href=base_url+'adminusers';
				});
			}
			else
			{
				swal({
					title: "Error",
					text: response.msg,
					icon: "error",
					button: "okay",
					closeOnEsc: false,
					closeOnClickOutside: false
				}).then(function(){ 
					location.reload();
				});
			}
		}
	});
	return false;
}); 

$('#service_category').on('change',function(){
	var category_id= $(this).val();
	get_category_data(category_id);		
});
$('#main_category').on('change',function(){
	var category_id= $(this).val();
	get_category_data(category_id);		
});

$('#service_subcategory').on('change',function(){
	var subcategory_id= $(this).val();
	var category_id= $('#service_category').val();
	get_subcategory_data(category_id, subcategory_id)
});		

function get_subcategory_data(category_id, subcategory_id)	{
	if(category_id !='' || subcategory_id != '') {
		$.ajax({
			type: "post",
			url: base_url+'admin/Categories/getServiceTitle',
			data:{category_id:category_id, subcategory_id:subcategory_id, 'csrf_token_name':csrf_token}, 
			dataType:'json',
			success: function (data) {
				if(data!=''){
					var fil_categories = data;
					
				$('#service_title').empty();
	            $('#service_title').append("<option value='' selected disabled='disabled'>Select Subcategory</option>");
	            for(var i=0; i<fil_categories.length; i++) {
	            	console.log(fil_categories[i].service_title);
	                $('#service_title').append("<option value="+fil_categories[i].id+">"+fil_categories[i].service_title+"</option>");                      
	            }
				}
			}
		});		
	} 
}

function get_category_data(category_id) {
	if(category_id !='') {
		$.ajax({
			type: "post",
			url: base_url+'admin/Categories/get_subcategory',
			data:{category_id:category_id, 'csrf_token_name':csrf_token}, 
			dataType:'json',
			success: function (data) {
				if(data!=''){
					var fil_categories = data;
					$('#service_subcategory').empty();
	            	$('#service_subcategory').append("<option value='' selected disabled='disabled'>Select Subcategory</option>");
		            for(var i=0; i<fil_categories.length; i++) {
		            	console.log(fil_categories[i].subcategory_name);
		                $('#service_subcategory').append("<option value="+fil_categories[i].id+">"+fil_categories[i].subcategory_name+"</option>");                      
		            }
				}
			}
		});		
	} 
}		

	//Added New
	//User form validation
	//var user_csrf_token=$('#user_csrf').val();
	$('#add_user').bootstrapValidator({
		fields: {
			name: {
				validators: {
					remote: {
						url: base_url + 'admin/dashboard/check_user_name',
						data: function(validator) {
							return {
								name: validator.getFieldElements('name').val(),
								csrf_token_name: csrf_token,
								id:$('#user_id').val()
							};
						},
						message: 'User Name is already exist',
						type: 'POST'
					},
					notEmpty: {
						message: 'User Name is Required'

					}
				}
			},
			country_code: {
				validators: {

					notEmpty: {
						message: 'User Country Code is Required'
					}
				}
			},
			mobileno: {
				validators: {
					remote: {
						url: base_url + 'admin/dashboard/check_user_mobile',
						data: function(validator) {
							return {
								name: validator.getFieldElements('mobileno').val(),
								country_code: validator.getFieldElements('country_code').val(),
								csrf_token_name: csrf_token,
								id:$('#user_id').val()
							};
						},
						message: 'User Mobile Number is already exist',
						type: 'POST'
					},
					notEmpty: {
						message: 'User Mobile is Required'
					}
				}
			},
			email: {
				validators: {
					remote: {
						url: base_url + 'admin/dashboard/check_user_email',
						data: function(validator) {
							return {
								name: validator.getFieldElements('email').val(),
								csrf_token_name: csrf_token,
								id:$('#user_id').val()
							};
						},
						message: 'Email is already exist',
						type: 'POST'
					},
					notEmpty: {
						message: 'Email is Required'

					}
				}
			},
			profile_img:           {
			   validators:           {
				file: {
				  extension: 'jpeg,png,jpg,gif',
				  type: 'image/jpeg,image/png,image/jpg,image/gif',
				  message: 'The selected file is not valid. Only allowed jpeg,jpg,png,gif files'
				}
			  }
			},
			status: {
				validators: {
					notEmpty: {
						message: 'Status is Required'
					}
				}
			},
		}
	}).on('success.form.bv', function(e) {
		var formData = new FormData(document.getElementById('add_user'));
		$.ajax({
			type:'POST',
			url: base_url+'admin/dashboard/update_user',
			enctype: 'multipart/form-data',
			data: formData,
			cache: false,						
			contentType: false,
			dataType: 'json',
			processData: false,
			success:function(response)
			{
				//console.log(response);return false;
				if(response.status)
				{
					swal({
						title: "Success",
						text: response.msg,
						icon: "success",
						button: "okay",
						closeOnEsc: false,
						closeOnClickOutside: false
					}).then(function(){ 
						window.location.href=base_url+'users';
					});
				}
				else
				{
					swal({
						title: "Error",
						text: response.msg,
						icon: "error",
						button: "okay",
						closeOnEsc: false,
						closeOnClickOutside: false
					}).then(function(){ 
						location.reload();
					});
				}
			}
		});
		return false;
	});


	//Provider
	//var user_csrf_token=$('#provider_csrf').val();
	$('#admin_category').on('change',function(){
		fetchsubcategory();
	}); 

	function fetchsubcategory(){
		var id=$("#admin_category").val();		
		$('#subcategorys_old').html('<option value="">Select subcategory</option>');
		$.ajax({
			type: "POST",
			url: base_url+"admin/service/fetch_subcategorys",
			data:{id:id,csrf_token_name:csrf_token}, 
			beforeSend :function(){
				$('#subcategorys').find("option:eq(0)").html("Please wait..");
			}, 
			success: function (data) {
				//console.log(data);
				var obj=jQuery.parseJSON(data);  //console.log(obj);
				$('#subcategorys').find('option').remove(); 
				if(obj.length > 0) {
					$('#subcategorys').find("option:eq(-1)").html("Select SubCategory");
					$(obj).each(function(){
						var option = $('<option />');
						option.attr('value', this.value).text(this.label);
						$('#subcategorys').append(option);
					});
				}       
			}
		});
	}

	//Provider form validation
	$('#add_provider').bootstrapValidator({
		fields: {
			category: {
				validators: {
					notEmpty: {
						message: 'Category is Required'
					}
				}
			},
			name: {
				validators: {
					remote: {
						url: base_url + 'admin/service/check_provider_name',
						data: function(validator) {
							return {
								name: validator.getFieldElements('name').val(),
								csrf_token_name: csrf_token,
								id:$('#user_id').val()
							};
						},
						message: 'Provider Name is already exist',
						type: 'POST'
					},
					notEmpty: {
						message: 'Provider Name is Required'

					}
				}
			},
			country_code: {
				validators: {

					notEmpty: {
						message: 'Provider Country Code is Required'
					}
				}
			},
			mobileno: {
				validators: {
					remote: {
						url: base_url + 'admin/service/check_provider_mobile',
						data: function(validator) {
							return {
								name: validator.getFieldElements('mobileno').val(),
								country_code: validator.getFieldElements('country_code').val(),
								csrf_token_name: csrf_token,
								id:$('#user_id').val()
							};
						},
						message: 'Provider Mobile Number is already exist',
						type: 'POST'
					},
					notEmpty: {
						message: 'Provider Mobile is Required'
					}
				}
			},
			email: {
				validators: {
					remote: {
						url: base_url + 'admin/service/check_provider_email',
						data: function(validator) {
							return {
								name: validator.getFieldElements('email').val(),
								csrf_token_name: csrf_token,
								id:$('#user_id').val()
							};
						},
						message: 'Provider Email is already exist',
						type: 'POST'
					},
					notEmpty: {
						message: 'Provider Email is Required'

					}
				}
			},
			profile_img:           {
			   validators:           {
				file: {
				  extension: 'jpeg,png,jpg,gif',
				  type: 'image/jpeg,image/png,image/jpg,image/gif',
				  message: 'The selected file is not valid. Only allowed jpeg,jpg,png,gif files'
				}
			  }
			},
			status: {
				validators: {
					notEmpty: {
						message: 'Status is Required'
					}
				}
			},
		}
	}).on('success.form.bv', function(e) {
		var formData = new FormData(document.getElementById('add_provider'));
		$.ajax({
			type:'POST',
			url: base_url+'admin/service/update_provider',
			enctype: 'multipart/form-data',
			data: formData,
			cache: false,						
			contentType: false,
			dataType: 'json',
			processData: false,
			success:function(response)
			{
				//console.log(response);return false;
				if(response.status)
				{
					swal({
						title: "Success",
						text: response.msg,
						icon: "success",
						button: "okay",
						closeOnEsc: false,
						closeOnClickOutside: false
					}).then(function(){ 
						window.location.href=base_url+'service-providers';
					});
				}
				else
				{
					swal({
						title: "Error",
						text: response.msg,
						icon: "error",
						button: "okay",
						closeOnEsc: false,
						closeOnClickOutside: false
					}).then(function(){ 
						location.reload();
					});
				}
			}
		});
		return false;
	});

	if($('#subcategorys').val() == '-1'){
      $('#subcategorys').focus(); alert("Select Subcategory");
      return false
  	}


  	$('.chngstatus').on('change', function(){ 
  		var statusId = $(this).val();
  		if(statusId) {
  			var b_rowid = $(this).attr('data-id');
  			//alert(b_rowid);
  			var b_userid = $(this).attr('data-userid'); 
  			var b_providerid = $(this).attr('data-providerid'); 
  			var b_serviceid = $(this).attr('data-serviceid'); 
  			//var r = confirm("Are you Sure About This process");
  			swal({
			  title: "Are you sure about this process ?",
			  text: "",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
			  		var url = base_url + 'admin/Booking/change_status_byAdmin';
				  	var data = { 
				  		status: statusId,
				  		id: b_rowid,
						user_id: b_userid,
						provider_id: b_providerid,
						service_id: b_serviceid,
						csrf_token_name:csrf_token
					};
				 	$.ajax({
						url: url,
						data: data,
						type: "POST",
						dataType: 'json',
						success: function (response) { 

							if(response=='3') { // session expiry
			              swal({
			                title: "Session was Expired... !",
			                text: "Session Was Expired ..",
			                icon: "error",
			                button: "okay",
			                closeOnEsc: false,
			                closeOnClickOutside: false
			              }).then(function(){
			                window.location.reload();
			              });
			            }

			            if(response=='2'){ //not updated
								swal({
									title: "Somethings wrong !",
									text: "Somethings wents to wrongs",
									icon: "error",
									button: "okay",
									closeOnEsc: false,
									closeOnClickOutside: false
								}).then(function(){
									window.location.reload();
								});
							}
								        
							if(response=='1'){ //updated
								swal({
									title: "Updated the booking status !",
									text: "Service is Updated successfully...",
									icon: "success",
									button: "okay",
									closeOnEsc: false,
									closeOnClickOutside: false
								}).then(function(){
									window.location.href=base_url+'admin/total-report';	
								});
							}						   
						}
					});
				} else {
					return false;
				}
			});

  		}
  	});


  	//block user/provider by admin
	$('.blockbyAdmin').on('click',function(){ 
		var rowId = $(this).attr('data-rowid');
		var blockedId = $(this).attr('data-blockedid');
		var blockedById = $(this).attr('data-blockedbyid');
		var userType = $(this).attr('data-usertype');
		//alert(rowId+' / '+blockedId+' / '+blockedById+' / '+userType);
		var statusId = 1;
      
		if(blockedId && blockedById) { 
  			swal({
			  title: "Are you sure about this process ?",
			  text: "",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
			  		var url = base_url + 'admin/dashboard/blocked_users_byAdmin';
				  	var data = { 
				  		status: statusId,
				  		id: rowId,
						blockedId: blockedId,
						blockedById: blockedById,
						userType: userType,
						csrf_token_name:csrf_token
					};
				 	$.ajax({
						url: url,
						data: data,
						type: "POST",
						dataType: 'json',
						success: function (response) {  //alert(response);

							if(response=='3') { // session expiry
			              swal({
			                title: "Session was Expired... !",
			                text: "Session Was Expired ..",
			                icon: "error",
			                button: "okay",
			                closeOnEsc: false,
			                closeOnClickOutside: false
			              }).then(function(){
			                window.location.reload();
			              });
			            }

			            if(response=='2'){ //not updated
								swal({
									title: "Somethings wrong !",
									text: "Somethings wents to wrongs",
									icon: "error",
									button: "okay",
									closeOnEsc: false,
									closeOnClickOutside: false
								}).then(function(){
									window.location.reload();
								});
							}
								        
							if(response=='1'){ //updated
								if(userType == 1) var utype = "Provider";
								var utype = "User"
								swal({
									title: "Updated the blocking status !",
									text: utype + " is Blocked successfully...",
									icon: "success",
									button: "okay",
									closeOnEsc: false,
									closeOnClickOutside: false
								}).then(function(){
									//window.location.href=base_url+'provider-block';	
									window.location.reload();
								});
							}						   
						}
					});
				} else {
					return false;
				}
			});
  		}
	});
	
	//block user/provider by admin
	$('.unblockbyAdmin').on('click',function(){ 
		var rowId = $(this).attr('data-rowid');
		var blockedId = $(this).attr('data-blockedid');
		var blockedById = $(this).attr('data-blockedbyid');
		var userType = $(this).attr('data-usertype');
		//alert(rowId+' / '+blockedId+' / '+blockedById+' / '+userType);
		var statusId = 0;
      
		if(blockedId && blockedById) { 
  			swal({
			  title: "Are you sure about this process ?",
			  text: "",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
			  		var url = base_url + 'admin/dashboard/unblocked_users_byAdmin';
				  	var data = { 
				  		status: statusId,
				  		id: rowId,
						blockedId: blockedId,
						blockedById: blockedById,
						userType: userType,
						csrf_token_name:csrf_token
					};
				 	$.ajax({
						url: url,
						data: data,
						type: "POST",
						dataType: 'json',
						success: function (response) {  //alert(response);

							if(response=='3') { // session expiry
			              swal({
			                title: "Session was Expired... !",
			                text: "Session Was Expired ..",
			                icon: "error",
			                button: "okay",
			                closeOnEsc: false,
			                closeOnClickOutside: false
			              }).then(function(){
			                window.location.reload();
			              });
			            }

			            if(response=='2'){ //not updated
								swal({
									title: "Somethings wrong !",
									text: "Somethings wents to wrongs",
									icon: "error",
									button: "okay",
									closeOnEsc: false,
									closeOnClickOutside: false
								}).then(function(){
									window.location.reload();
								});
							}
								        
							if(response=='1'){ //updated
								if(userType == 1) var utype = "Provider";
								var utype = "User"
								swal({
									title: "Updated the blocking status !",
									text: utype+" Unblocked successfully...",
									icon: "success",
									button: "okay",
									closeOnEsc: false,
									closeOnClickOutside: false
								}).then(function(){
									//window.location.href=base_url+'provider-block';	
									window.location.reload();
								});
							}						   
						}
					});
				} else {
					return false;
				}
			});
  		}
	});







		
})(jQuery);