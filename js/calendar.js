function calendar_click_day(day){
   $.ajax({
      url: "/server/calendar.php?d="+day,
      type: 'get',
      success: function(getdata){
          alert(getdata);
      }
   });
}







