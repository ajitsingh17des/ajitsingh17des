var siteURL = 'http://sd51:8080/neha/reva_new/';    
     
    
/****************************************Faculty searching js start here**************************************************/   
/*
$(document).on('change', '#college', function(e) {
    var college_id      =   $(this).val();
    var department_id      =   $(this).val();
  //  alert(department_id);
    if(college_id){
        $.ajax({
                url: siteURL+"filter/faculty_search",
                method : "POST",
                data : {college_id:college_id},
                async : true,
                dataType : 'json',
                success: function(data){
                   
                //  $('.department_div').html(data.department_select);
                }
        });
    }
});
*/      
/****************************************All Faculty Listing js start here**************************************************/ 
$(document).on('click', '.loadMore_fac', function(e) {
  var limit = $('#to_limit_id').val();
  var from_limit = $('#from_limit_id').val();
  var controller_name = $('#controller_id').val();  
  if(limit){
      //$('.loader').css("display", "inline-block");        
        $.ajax({
                url: siteURL+controller_name+"/listing",
                method : "POST",
                data : {limit:limit,fromlimit:from_limit},
                async : true,
                //dataType : 'json',
                success: function(data){
                  from_limit++;
                  $('#from_limit_id').val(from_limit);
                  $('.pagination_loader').append(data);
                  //$('.loadMore_fac').css("display", "none");
                  //$('.loader').css("display", "none");
                }
        });
    }
});  
/*****************  FUNCTION FOR CHECK EMAIL START HERE **************/
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
/*****************  FUNCTION FOR CHECK EMAIL END HERE **************/

