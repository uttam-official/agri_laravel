$(document).ready(function(){
    $('#setting_form').on('submit',function(e){
        const regEx=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        const email=$('#email');
        const password=$('#password');
        if(!regEx.test(email.val())){
            e.preventDefault();
            toastr.warning('Please enter a valid email id');
            email.addClass('is-invalid');
        }
        if(password.val()==""){
            e.preventDefault();
            toastr.warning('Password required');
            password.addClass('is-invalid');
        }
    })
})