<div id="{{$modal}}" class="modal">
  <div class="modal-content">
    <h4 class="red-text">Delete {{$title}}!</h4>
    <p class="grey-text text-darken-1">Are you sure?</p>
  </div>
  <div class="modal-footer">
    <a href="#!" onclick="this.preventDefault;document.getElementById('{{$id}}').submit();" class="modal-close waves-effect waves-red btn-flat">Yes</a>
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">No</a>
  </div>
</div>