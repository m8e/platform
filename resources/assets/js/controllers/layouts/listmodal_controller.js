import {Controller} from "stimulus";

export default class extends Controller {

    /**
     *
     */
    connect() {

    }
    
    save (event) {
       event.preventDefault();
       
       const posturl = this.data.get('url')+'/save';
       const formData = $("#screen-modal-post .modal-content").serializeArray();
      
       let element = this.element;
       
       //console.log("ISave "+posturl);
       
       
       axios({
          url: posturl,
          method: 'POST',
          data: formData,
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then();
       /*
       var response = axios.post(url,)
                .then(function (response) {
                    $('#screen-modal-post .modal-body').append($.parseHTML(response.data)).text();
                    $('#screen-modal-post').attr('data-layouts--listmodal-url',url);
                    $('#screen-modal-post').modal('show');
                });*/
    }

}