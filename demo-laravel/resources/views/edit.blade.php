<img src="{{ asset('storage/' . $paint->image_path) }}" alt="Paint Image">
<form action="{{ route('paints.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="paint_name" placeholder="Paint Name">
    <textarea name="description" placeholder="Description"></textarea>
    <textarea name="details" placeholder="Details"></textarea>

    <input type="file" name="image">

    <button type="submit">Save Paint</button>
</form>
