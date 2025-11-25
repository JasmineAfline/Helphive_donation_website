@extends('layouts.app') <!-- Adjust this to your layout -->

@section('content')
<div class="container">
    <h1>Donate to {{ $campaign->name }}</h1>
    <form action="{{ route('donate.submit') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" name="amount" id="amount" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Donate</button>
    </form>
</div>
@endsection
w