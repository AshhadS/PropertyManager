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

    

    // Adding the required indicator and property to block form submit
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
    confirmSubmit();

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





// Margin validation

