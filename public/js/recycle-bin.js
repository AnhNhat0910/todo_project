// Alert Button Restore 1 task
$('.btn-restore').on('click', function (e) {
    e.preventDefault();
    const href = $(this).attr('href');
    Swal.fire({
        title: 'Are you sure?',
        text: "Restore this task!",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.location.href = href;
            Swal.fire(
                'Restored!',
                "Your task has been restored",
                'success'
            )
        }
    })
});
//Select all row
$(document).on('click', '#select_all', function () {
    $(".checkItem").prop("checked", this.checked);
    $("#select_count").html("Restore " + $("input.checkItem:checked").length + " Rows Selected");

    if ($("input.checkItem:checked").length == 0) {
        $("#select_count").html($("input.checkItem:checked").length + " Row Selected ");
    }
});

//Count row selected
$(document).on('click', '.checkItem', function () {
    if ($('.checkItem:checked').length == $('.checkItem').length) {
        $('#select_all').prop('checked', true);
    } else {
        $('#select_all').prop('checked', false);
    }
    $("#select_count").html("Restore " + $("input.checkItem:checked").length + " Row Selected ");

    if ($("input.checkItem:checked").length == 0) {
        $("#select_count").html($("input.checkItem:checked").length + " Row Selected ");
    }
    if ($("input.checkItem:checked").length > 1) {
        $("#select_count").html("Restore " + $("input.checkItem:checked").length + " Rows Selected ");
    }
});

//Restore Row selected
$('#btn-restore').on('click', function (e) {
    var employee = [];
    $(".checkItem:checked").each(function () {
        employee.push($(this).data('checkbox-id'));
    });
    if (employee.length == 0) {
        Swal.fire("Please select task!", "No task selected", "info");
    }
    else {
        Swal.fire({
            title: 'Are you sure?',
            text: "Restore " + (employee.length > 1 ? employee.length + " rows?" : employee.length + " row?"),
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var selected_values = employee.join(",");
                console.log(selected_values);
                $.ajax({
                    type: "post",
                    url: "/recyclebin/resrowschecked",
                    data: "emp_id=" + selected_values,
                    success: function (response) {
                        if (response == "success") {
                            Swal.fire({
                                title: "Success",
                                text: "Successful restore",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Confirm me!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                            window.location.href = "/recyclebin/index";
                        }
                        else {
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
        })
    }
});