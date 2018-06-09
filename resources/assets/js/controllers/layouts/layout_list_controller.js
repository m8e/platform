import {Controller} from "stimulus";

export default class extends Controller {

    static targets = [ "modal" ]
    /**
     *
     */
    connect() {
        
    }
    
    edit () {
       const url = this.data.get('url')
       //var modaldata = '';
       let element = this.element;
       let modalTarget =this.modalTarget;
       
       
       var response = axios.post(url)
                .then(function (response) {
                    //modaldata =response;
                    //element.querySelector('.modal').innerHTML = response.data;
                    var box1 = $.parseHTML(response.data);//$(response.data).find('#screen-modal-post');                     
                    //console.log(box1);
                    //element.querySelector('.modal').appendChild(box1); 
                    $('#modals-container').append(box1).text();
                    //modalTarget.append(response.data); 
                    
                    $('#screen-modal-post').modal('show');
                    //console.log(response.data);
                });
                
       //this.modalTarget.innerHTML = response; 
       //console.log(modaldata);
    }


}