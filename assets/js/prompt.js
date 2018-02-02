function invalidSrc()
{
	 $(document).ready(function() {

                $.notify({
                    icon: 'ti-thumb-down',
                    message: "Invalid source address"

                }, {
                    type: 'danger',
                    timer: 4000
                });

            });
}

function invalidDest()
{
	 $(document).ready(function() {

                $.notify({
                    icon: 'ti-thumb-down',
                    message: "Invalid destination address"

                }, {
                    type: 'danger',
                    timer: 4000
                });

            });
}

function notInSG(field){
   $(document).ready(function(){
   
      	$.notify({
          	icon: 'ti-thumb-down',
          	message: field+" not in Singapore"
   
          },{
              type: 'danger',
              timer: 4000
          });
   
   });
}



function success(){
   $(document).ready(function(){
   
      	$.notify({
          	icon: 'ti-thumb-up',
          	message: "Success"
   
          },{
              type: 'success',
              timer: 4000
          });
   
   });
}

   function failure(){
   $(document).ready(function(){
   
      	$.notify({
          	icon: 'ti-thumb-down',
          	message: "Failure"
   
          },{
              type: 'danger',
              timer: 4000
          });
   
   });
   }
   