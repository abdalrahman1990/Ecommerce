<form action="{{route('admin.reports.'.$route)}}" class="hide" id="{{$form}}">
    <input type="hidden" name="type" value="{{request()->type}}">
    <input type="hidden" name="date_to" value="{{request()->date_to}}">
    <input type="hidden" name="date_from" value="{{request()->date_from}}">
</form>