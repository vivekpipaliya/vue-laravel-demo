<form action="{{url('/api/submit')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input placeholder="A" name="name" />
    <input placeholder="A" name="email" />
    <input placeholder="A" name="phone_number" />
    <input placeholder="A" name="address" />
    <input placeholder="A" name="zipcode" />
    <input placeholder="A" type="file" name="document" />
    <button name="Execute">Execute</button>
</form>