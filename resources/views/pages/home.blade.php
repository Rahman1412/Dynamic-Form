@extends('app')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between p-3">
        <h3>All Items</h3>
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal">
            Add New Item
        </button>
    </div>
</div>

<div class="modal" id="myModal">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New Items</h4>
        <button type="button" onclick="toggleModel()">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form id="item_form" method="POST" enctype="multipart/form-data">
            @csrf
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Amount</th>
                        <th colspan="2">Image</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <button type="submit" class="btn btn-primary btn-block submit">
                Submit
            </button>
        </form>
      </div>

    </div>
  </div>
</div>

@endsection


@section('script')

<script>
    let i = 1;
    $(document).ready(function(){
        addField(i)
        $('#item_form').on('submit', function(e){
            e.preventDefault();
            handleButton(true);
            $(".text-danger").remove();
            let formData = new FormData();
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            let title = $("input[name='title[]']").map(function(){ return $(this).val(); }).get();
            let price = $("input[name='price[]']").map(function(){ return $(this).val(); }).get();
            let files = $("input[name='file[]']");
            $.each(title, function(index, value) {
                formData.append('title[]', value);
            });
            $.each(price, function(index, text) {
                formData.append('price[]', text);
            });
            $.each(files, function(index, fileInput) {
                if (fileInput.files.length > 0) {
                    console.log("Inedx"+index)
                    formData.append(`file[${index}]`, fileInput.files[0]);
                }else{
                    console.log("File"+index)
                    formData.append(`file[${index}]`, null);
                }
            });

            jQuery.ajax({
                url:BASE_URL+"/add-items",
                type:"POST",
                data:formData,
                contentType:false,
                processData:false,
                dataType:"JSON",
                success:function(resp){
                    console.log("Response",resp);
                },
                error:function(err){
                    handleButton(false);
                    let response = err.responseJSON
                    let error = response?.error;
                    if(response?.code == "validation_error"){
                        Object.keys(error).forEach(function(field) {
                            let split = field.split(".");
                            var name = split[0];
                            var fieldindex = split[1];
                            var fieldName = name+"[]";
                            const fieldElement = $(`[name="${fieldName}"]`).eq(fieldindex);
                            fieldElement.siblings('.text-danger').remove();
                            const errorElement = document.createElement('span');
                            errorElement.className = 'text-danger';
                            errorElement.innerText = error[field][0].replace(`.${fieldindex}`, "");
                            fieldElement.after(errorElement);
                        });
                    }else{

                    }
                }
            });
        });
    })

    function toggleModel(){
        i = 1;
        $('#myModal').modal('toggle')
        addField(1);
    }

    function handleButton(isDisable){
        if(isDisable){
            $(".submit").html("<span class='spinner-border spinner-border-sm'></span> Please wait...");
            $(".submit").prop('disabled', true);
        }else{
            $(".submit").html("Submit");
            $(".submit").prop('disabled', false);
        }
    }

    function addMore(element){
        i++;
        addField(i)
    }

    function addField(number){
        console.log("Exce");
        if(number > 1)
        {
            let html = "<tr>\
                <td>\
                    <input type='text' class='form-control' placeholder='Item Name' name='title[]'>\
                </td>\
                <td>\
                    <input type='text' class='form-control' placeholder='Amount' name='price[]'>\
                </td>\
                <td>\
                    <input type='file' class='form-control' accept='image/*' name='file[]' multiple=''>\
                </td>\
                <td>\
                    <Button class='btn btn-danger' type='button' onclick='remove(this)'>\
                    Remove\
                    </Button>\
                </td>\
            </tr>";
            $('tbody').append(html);
        }else{
            let html = "<tr>\
                <td>\
                    <input type='text' class='form-control' placeholder='Item Name' name='title[]'>\
                </td>\
                <td>\
                    <input type='text' class='form-control' placeholder='Amount' name='price[]'>\
                </td>\
                <td>\
                    <input type='file' class='form-control' accept='image/*' name='file[]' multiple=''>\
                </td>\
                <td>\
                    <Button class='btn btn-primary' type='button' onclick='addMore(this)'>\
                    Add\
                    </Button>\
                </td>\
            </tr>";
            $('tbody').html(html);
        }
    }

    function remove(element){
        i--;
        $(element).closest("tr").remove();
    }
    </script>
@endsection