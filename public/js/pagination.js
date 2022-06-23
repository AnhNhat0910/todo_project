$(document).ready(function(){
    $('#listTable').DataTable({
       'processing': true,
       'serverSide': true,
       'serverMethod': 'post',
       'ajax': {
           'url':'/home'
       },
       'columns': [
          { data: 'id' },
          { data: 'name' },
          { data: 'description' },
          { data: 'createDate' },
          { data: 'lastModificationTime' },
       ]
    });
 });