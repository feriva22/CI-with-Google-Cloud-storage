function ajaxExtend(options,always){   //untuk memasukkan csrf tiap call ajax
    options.data[csrf_name] = Cookies.get(csrf_name);
	if(typeof(options.data[csrf_name]) == 'undefined'){
		//refresh if csrf token is not found
		document.location = document.location;
		return;
	}
	$.ajax({
        url: options.url,
        type: 'post',
        data: options.data,
        success: options.success,
        error: options.error,
        dataType : 'json',
        cache: false,
        beforeSend: options.beforeSend,
        complete: options.complete
    }).always(always);
}

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function page_loading(action){
    if(action == 'show'){
        $.LoadingOverlay("show",{
            background: "rgb(0,0,0,0.5)"
        });
    } else {
        $.LoadingOverlay("hide",true);
    }
}

function show_alert(status, message){
    final_string = message;
    if(typeof(message) === 'object'){
        final_string = '';
        Object.keys(message).forEach(function(key){
            final_string += `${message[key]}\n`;
        })
    }
    $('#alert_notice').append(`
                            <div class="alert alert-${status} alert-dismissible fade show" id="" role="alert">
                            <strong>${status} !</strong> ${final_string}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="ik ik-x"></i></button></div>`);
    setInterval(function(){
        $('#alert_notice').html('');
    }, 3000);
}

function show_notification(status,message){
    var notif_type = {
        'success' : { icon: 'success',loaderBg: '#f96868' },
        'warning' : { icon: 'warning',loaderBg: '#57c7d4'},
        'error'   : { icon: 'error',loaderBg: '#f2a654'}
    };
    $.toast({
        heading: status,
        text: message,
        showHideTransition: 'slide',
        icon: notif_type[status].icon,
        loaderBg: notif_type[status].loaderBg,
        position: 'top-right',
        hideAfter: 2000
      })
}

function page_click(selector,action){
    $('body').on('click',selector,action);
}

function toCurrency(number){
    return parseInt(number).toLocaleString(undefined,{minimumFractionDigits:2});
}

// dec2hex :: Integer -> String
// i.e. 0-255 -> '00'-'ff'
function dec2hex (dec) {
    return ('0' + dec.toString(16)).substr(-2)
  }
  
// generateId :: Integer -> String
function generateId (len) {
  var arr = new Uint8Array((len || 40) / 2)
  window.crypto.getRandomValues(arr)
  return Array.from(arr, dec2hex).join('')
}

function load_notification(view){
    ajaxExtend({
        url: base_url+'backend/dashboard/get_notif',
        data: {view: view},
        success:function(resp){
            $('#notif_container').html(resp.data.render);
            if(resp.data.unseen_count > 0){
                $('#count_unseennotif').html(resp.data.unseen_count);
            }
        }
    })
}

$(document).on('click','#notiDropdown',function(){
    $('#count_unseennotif').html('');

    load_notification('yes');
})

page_click('#chg_passwordbtn',function(e){
    $.confirm({
        title: 'Ubah Password Akun',
        content: '' +
        '<form action="" >' +
        '<div class="form-group">' +
        '<label>Password Saat Ini</label><br>' +
        '<input type="password" name="current_password" id="current_password" class="form-control" placeholder="Password Saat Ini">'+
        '</div>' +
        '<div class="form-group">'+
        '<label>Password Yang akan Diubah</label><br>' +
        '<input type="password" name="check_password" id="check_password" class="form-control" placeholder="Password Baru">'+
        '</div>'+
        '<div class="form-group">'+
        '<label>Konfirmasi Password</label><br>' +
        '<input type="password" name="chg_password" id="chg_password" class="form-control" placeholder="Konfirmasi Password Baru">'+
        '</div>'+
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Submit',
                btnClass: 'btn-blue',
                action: function () {
                    var cur_password = this.$content.find('input#current_password');
                    var check_password = this.$content.find('input#check_password');
                    var chg_password = this.$content.find('input#chg_password');                    
                    if(!cur_password.val().trim() || !check_password.val().trim() || !chg_password.val().trim()){
                        $.alert({
                            title: 'Peringatan',
                            content: "Isi Semua Form !",
                            type: 'red'
                        });
                        return false;
                    }else if(check_password.val() !== chg_password.val()){
                        $.alert({
                            title: 'Peringatan',
                            content: "Password Konfirmasi Tidak Sama !",
                            type: 'red'
                        });
                        return false;
                        
                    }else{
                        ajaxExtend({
                            url : base_url+'backend/login/change_password',
                            data : {
                                current_password : cur_password.val(),
                                chg_password : chg_password.val()
                            },
                            success: function(data){
                                console.log(data);
                                if(data.status == 'success'){
                                    setTimeout(function(){
                                        document.location = base_url+'backend/login/logout';
                                    },1500);
                                    $.alert({
                                        title: 'Peringatan',
                                        content: data.message,
                                        type: 'green'
                                    });
                                    return false;
                                    
                                }else{
                                    $.alert({
                                        title: 'Peringatan',
                                        content: data.message,
                                        type: 'red'
                                    });
                                    return false;
                                }
                            },
                            error: function(jXhr){show_notification('error','Kesalah Koneksi Server');return false;}
                        })
                    } 
                }
            },
            batal: function () {},
        },
        onOpen: function(){
            
        },
        onOpenBefore: function () {
        }
    });
})