$(function() {

    // Auto select tab based on the url hash
    var hash = window.location.hash;
    hash && $('ul.nav a[href="' + hash + '"]').tab('show');


    $('#login-form-link').click(function(e) {
        $("#login-form").delay(100).fadeIn(100);
        $("#register-form").fadeOut(100);
        $('#register-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });
    $('#register-form-link').click(function(e) {
        $("#register-form").delay(100).fadeIn(100);
        $("#login-form").fadeOut(100);
        $('#login-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });

    if(window.location.hostname == "portal.ibsswjt.com"){
        $('.phpdebugbar').hide();
    }

    

    //Adding the required indicator and property to block form submit
    $( ".input-req" ).wrap( "<span class='input-req'></span>" );
    $( ".input-req" ).attr( "required", true );
    $( "span.input-req" ).append('<span class="input-req-inner"></span>');

    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'dd/mm/yyyy',
    });

    // Confirm on delete
    $('.delete-btn').on('click', function(e){
        e.preventDefault();
            btn = this;
            if($(btn).hasClass('activate')){
            console.log('Now delete!'); 
            $(btn).closest('form.delete-form').submit();
        } else{
            $(btn).addClass('activate');
            setTimeout(function(){
              $(btn).removeClass('activate');
            }, 5000);
        }
    });

    // Confirm on delete
  $('.delete-btn-rp').on('click', function(e){
      e.preventDefault();
          btn = this;
          if($(btn).hasClass('activate')){
          console.log('Now delete!'); 
          $(btn).closest('form.delete-form').submit();
      } else{
          $(btn).addClass('activate');
          setTimeout(function(){
            $(btn).removeClass('activate');
          }, 5000);
      }
  });




    // Attachments edit autofill
    $('.edit-attachment').on('click', function(){
        data = $(this).siblings('.data-defined');
        console.log($(data).data('documentAutoID'));
        $('.edit-form [name="attachmentID"]').val($(data).data('id'))
        $('.edit-form [name="documentAutoID"]').val($(data).data('documentautoid'))
        $('.edit-form [name="documentID"]').val($(data).data('documentid'))
        $('.edit-form [name="description"]').val($(data).data('description'))
        $('.edit-form [name="fileNameCustom"]').val($(data).data('filenamecustom'))
        $('.edit-form [name="fileNameSlug"]').val()

        // console.log($(data).data('filenameslug'));
        // if file has been added
        if($(data).data('filenameslug')){
            $('.edit-form .file-input').addClass('hide-element');
            $('.edit-form .image-exists').removeClass('hide-element');
            $('.edit-form .remove-attachment').removeClass('hide-element');

        }else{
            // file not added
            $('.edit-form .file-input').removeClass('hide-element');
            $('.edit-form .image-exists').addClass('hide-element');
            $('.edit-form .remove-attachment').addClass('hide-element');
            $('[name="attachmentFile"]').attr('required', 'required');
        }
    });

    $('[data-toggle="tooltip"]').tooltip()
    $('[data-toggle="popover"]').popover()
    
    

    // Show file upload field only if no image has been added 
    $('.remove-attachment, .remove-image').click(function(){
        $('.image-exists').addClass('hide-element');
        $('.file-input').removeClass('hide-element');
        $('.remove-attachment, .remove-image').addClass('hide-element');
    });


    // Property Image
    if($('.image-edit').hasClass('image-true')){
        console.log('image'); 
        $('.file-input').addClass('hide-element');
    }else{
        console.log('no'); 
        $('.image-exists').addClass('hide-element');
        $('.remove-image').addClass('hide-element');
    }

    // Format date
    $('.format-date').text(function(){
        var date = new Date($(this).text());
        if(!isNaN(date.getTime())){
          // return the two digit date and month
          return ("0" + date.getDate()).slice(-2) +'/'+ ("0" + (date.getMonth() + 1)).slice(-2) +'/'+ date.getFullYear();
        }else{
          // retun empty string if not selected
          return '';
        }
    });

    // Hamburger
    $('.nav-toggle .fa-bars').on('click', function(){
        $('.nav-items').slideToggle();
    });

    initializeTeleValidation();
    initializePercentageValidation();
    addBankPopover()
    confirmSubmit();
    relatedAccouts();


    // Remove active if a link with no tab is clicked example property owner edit
    $('.edit-remove-actives').on('click', function(){
        $('li.active').removeClass('active');
    })




    $(document).ajaxComplete(function() {
        // Adding the required indicator and property to block form submit
        $( ".input-req" ).wrap( "<span class='input-req'></span>" );
        $( ".input-req" ).attr( "required", true );
        $( "span.input-req" ).append('<span class="input-req-inner"></span>');

        // Confirm on delete
        $('.delete-btn').on('click', function(e){
            e.preventDefault();
                btn = this;
                if($(btn).hasClass('activate')){
                console.log('Now delete!'); 
                $(btn).closest('form.delete-form').submit();
            } else{
                $(btn).addClass('activate');
                setTimeout(function(){
                  $(btn).removeClass('activate');
                }, 5000);
            }
        });

        

        initializeTeleValidation();
        initializePercentageValidation();
        confirmSubmit();
        addBankPopover()

    });
             
});

// Phone number validation - only digits and max 10 numbers
function initializeTeleValidation(){
    // Remove alphabets
    $('[type="tel"]').keyup(function () { 
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });
    $('.input-tel').keyup(function () { 
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });

    // max 10 digits
    $("input[type=tel]").attr('maxlength', '10');

    // custom html 5 pattern valdation
    $("input[type=tel]").oninvalid = function () {
        this.setCustomValidity("This field required 10 digits.");
        this.setCustomValidity("");
    };
}
function initializePercentageValidation(){
    // Remove alphabets
    $('.percentage').keyup(function () { 
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });

    // max 3 digits
    $(".percentage").attr('maxlength', '3');
}

function confirmSubmit(){
    // Confirm Submit - Rentalowner, Tentant, Agreement
    $('form.confirm-submit').on('submit', function(e){
        var r = confirm("Confirm Performing this action?");
        if (r == false) {
            return false;
        }
    });
}

function addBankPopover(){
    $('.account-popover-launch').popover({
        html: true,
        title: 'Add Account',
        content: function(){
            var output = '';
            output += '<form class="form-horizontal ajax-process pull" action="/account" method="POST">';
            output += '<input type="hidden" name="_token" value="'+ $('meta[name="_token_del"]').attr('content') +'">';
            output += '<input type="hidden" name="bankmasterID" value="'+ $(this).data('bankid') +'">';
            output += '<div class="simple-add-textbox-wrapper pull-left">';
            output += '<span class="input-req" required="required"><input type="text" name="accountNumber" placeholder="Account Number" class="input-req  form-control" required="required"><span class="input-req-inner"></span></span>';
            output += '</div>';
            output += '<button type="submit" data-section="banks" class="btn btn-info simple-add-btn pull-left " data-section="banks"><i class="fa fa-plus"></i> Add</button>';
            output += '</form>';
            return output;
        },
    });

    $('.account-popover-launch').on('inserted.bs.popover', function () {
      initAjaxSubmit();
    });

    $('html').on('click', function(e) {
      if (typeof $(e.target).data('original-title') == 'undefined' &&
         !$(e.target).parents().is('.popover.in')) {
        $('[data-original-title]').popover('hide');
      }
    });

    
}

function initAjaxSubmit() {
    console.log('init ajax submit'); 
    $('.ajax-process').on('submit', function(e) {
        e.preventDefault();
        $('#myModal').modal('hide');
        var section = $(this).find('button').data('section');
        $.ajax({
            url : $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            success: function (data) {
                console.info('success');
                $('.page-content').show();
                $('.load-container').fadeIn();
                $('.page-content .body').load( "/"+section+"/");

            },
            error: function (jXHR, textStatus, errorThrown) {
                console.info(errorThrown);
            }
        });
    });
}


function relatedAccouts() {
    // filter child selection on page load
      childSelection($('.selection-parent-item-bank'));
      

      // $('.no-units').hide();
      // Load content based on previous selection
      $('.selection-parent-item-bank').on('change', function(){
        childSelection(this)
      });

      
}

function childSelection(elem){
    var prev_selection = $('.selection-child-item-account.edit').val();
    if ($(elem).val() != 0) {
      $('.selection-child-item-account').show();
      $('.no-units').hide();
      $.ajax({
          url: "/bank/getaccounts/"+$(elem).val()+"",
          context: document.body,
          method: 'POST',
          async: false,
          headers : {'X-CSRF-TOKEN': $('meta[name="_token_del"]').attr('content')}
      })
      .done(function(data) {
          // show message if no units for the selected property
          if(data.length){
                console.log($('.selection-child-item-account').parent()); 
            $('.selection-child-item-account').parent().html(function(){
                // Generate the seletect list
                var output = '<span class="input-req"><select class="form-control selection-child-item-account" required="required" name="bankAccountID">';
                output += '<option value="">Select a account</option>';
                data.forEach(function( index, element ){
                    if(prev_selection == data[element].bankAccountID){
                      output += '<option value="'+data[element].bankAccountID+'" selected="selected">'+data[element].accountNumber+'</option>';
                    }else{
                      output += '<option value="'+data[element].bankAccountID+'">'+data[element].accountNumber+'</option>';
                    }
                });
                output += '</select><span class="input-req-inner"></span>';
                return output;
            });
          }else{
            $('.selection-child-item-account').hide();
            $('.no-units').show();
          }         
      });
    }else{
      $('.selection-child-item-account').hide();
      $('.no-units').show();
    }      
}
