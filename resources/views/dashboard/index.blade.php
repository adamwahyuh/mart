Duck you {{ Auth::user()->name }}!
You are an {{ Auth::user()->role }}.

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>