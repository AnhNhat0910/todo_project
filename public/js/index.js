    //Alert
	$('.btn-del').on('click',function(e) {
		e.preventDefault();
		const href = $(this).attr('href');
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
			if (result.isConfirmed) {
				document.location.href = href;
				Swal.fire(
				'Deleted!',
				"Your task has been deleted",
				'success'
				)
			}
			else{
				Swal.fire(
                "Cancelled",
                "Your action has been cancelled",
                "error"
            	)
			}
		})
	})
	//Alert Create Task
	document.getElementById('myModal').onsubmit = function(){
		Swal.fire({
        position: "top-right",
        icon: "success",
        title: "Your task has been created",
        showConfirmButton: false,
        timer: 2000
    });
	};
	//Modal for Update form
	$(document).on('click','a[data-role=update]', function(){
		var id = $(this).data('id');
		var name = $('#'+id).children('td[data-target=name]').text().trim();
		console.log(name);
		console.log(id);
		var description = $('#'+id).children('td[data-target=description]').text().trim();
		console.log(description);
	 	
		$('#name_update').val(name);
		$('#des_update').val(description);
		$('#id_update').val(id);
		$('#modalUpdate').toggle();
	});
	//Close modal Update form
	document.getElementById('closeUpdate').onclick = function(){
		$('#modalUpdate').hide();
	};
	//Alert for update form
	document.getElementById('updateForm').onsubmit = function(){
            Swal.fire({
            position: "top-right",
            icon: "success",
            title: "Your task has been updated",
            showConfirmButton: false,
            timer: 3000
        });
    }
		// Not allow the day has passed
	$(function(){
		var dtToday = new Date();
		
		var month = dtToday.getMonth() + 1;
		var day = dtToday.getDate();
		var year = dtToday.getFullYear();
		if(month < 10)
			month = '0' + month.toString();
		if(day < 10)
			day = '0' + day.toString();
		
		var minDate= year + '-' + month + '-' + day;
		
		$('#date').attr('min', minDate);
	});

	//Select all row
	$(document).on('click', '#select_all', function() {          	
		$(".checkItem").prop("checked", this.checked);
		$("#select_count").html("Delete "+$("input.checkItem:checked").length+" Rows Selected");
	});

	//Count row selected
	$(document).on('click', '.checkItem', function() {		
		if ($('.checkItem:checked').length == $('.checkItem').length) {
			$('#select_all').prop('checked', true);
		} else {
			$('#select_all').prop('checked', false);
		}
		$("#select_count").html("Delete "+$("input.checkItem:checked").length+" Row Selected ");

		if($("input.checkItem:checked").length ==0){
			$("#select_count").html($("input.checkItem:checked").length+" Row Selected ");
		}
		if($("input.checkItem:checked").length >1){
			$("#select_count").html("Delete "+$("input.checkItem:checked").length+" Rows Selected ");
		}
	});

	// delete selected records
	$('#btn-delRows').on('click', function(e) { 
	var employee = [];  
	$(".checkItem:checked").each(function() {  
		employee.push($(this).data('checkbox-id'));
	});	
	if(employee.length == 0)  {  
		Swal.fire("Please select record!", "No record selected", "info");
	}
	else { 	
		warning_delete = "Are you sure you want to delete "+(employee.length>1?"these":"this")+" row?";  
		var checked = confirm(warning_delete);  
	
		if(checked == true) {			
			var selected_values = employee.join(","); 
			console.log(selected_values);
			$.ajax({ 
				type: "post",  
				url: "/list/delete/rowschecked",  
				data: "emp_id="+selected_values,
				success: function(response) {
					if(response=="success"){
						Swal.fire({
							title: "Success",
							text: "Successful delete",
							icon: "success",
							buttonsStyling: false,
							confirmButtonText: "Confirm me!",
							customClass: {
							confirmButton: "btn btn-primary"
							}
						});	
						window.location.href="/home";
					}
					else{
						Swal.fire({
							position: "top-right",
							icon: "error",
							title: "Error",
							showConfirmButton: false,
							timer: 3000
       				 	});
					}		
				}   
			});				
		}  
	}  
});