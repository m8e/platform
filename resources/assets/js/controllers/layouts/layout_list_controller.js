import {Controller} from "stimulus";

export default class extends Controller {

    /**
     *
     */
    connect() {
       
    }
    
    edit () {
       const url = this.data.get('url')
       let element = this.element;
       
       var response = axios.post(url)
                .then(function (response) {
                    $('#screen-modal-post .modal-body').append($.parseHTML(response.data)).text();
                    $('#screen-modal-post').modal('show');
                });
    }

}