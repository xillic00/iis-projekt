@extends('layouts.master')

@section('content')
    <div class="container">
        <!-- Page Heading -->
        <h1 class="text-center">{{ $concertItem->getName() }}</h1>

        @if(session('role') == "admin" || session('role') == "organiser")
            <a href="{{ route('concert.editForm', $concertItem->getId()) }}">
                <button type="button" class="btn btn-info">Edit concert</button>
            </a>
            <a href="{{ route('concert.delete', ['concertid' => $concertItem->getId(), 'eventid' => $concertItem->getIisEventid()]) }}">
                <button type="button" class="btn btn-danger">Delete concert</button>
            </a>
        @endif
        @if(Auth::guest())
            <!-- Neprihlaseny uzivatel -->
                <a href="{{ route('login') }}">
                    <button type="button" class="btn btn-outline-success">Buy Tickets!</button>
                </a>
        @else
        <!-- Prihlaseny uzivatel -->
            <a href="{{ route('ticket.add', $concertItem->getIisEventid()) }}">
                <button type="button" class="btn btn-outline-success">Buy Tickets!</button>
            </a>
        @endif
        <hr>

        {{-- Page content--}}
        <div class="container">
            <div class="row">
                <div class="left-column">
                    <img src="{{ $concertItem->getImage() }}" onerror="this.src='{{ Storage::url($concertItem->getImage()) }}';" alt="Concert Image" style="width: 500px">
                    <br>
                    @if(session('role') == "admin" || session('role') == "organiser")
                        <b>Tickets</b>: <br>
                        <a href="{{ route('concert.addTicketType', [$concertItem->getIisEventid(), 'concertId' => $concertItem->getId()]) }}">
                            <button type="button" class="btn btn-success">Add New Ticket</button>
                        </a><br><hr>

                        @foreach($concertItem->getTickets() as $ticketTypeItem)
                            <b>Type</b>: {{ $ticketTypeItem->getType() }} <br>
                            <b>Price</b>: {{ $ticketTypeItem->getPrice() }} <br>
                            <a href="{{ route('concert.deleteTicketType', [$concertItem->getId(), $ticketTypeItem->getIisTicketTypeid()]) }}">
                                <button type="button" class="btn btn-outline-danger">Delete Ticket</button>
                            </a>
                            <hr>
                        @endforeach
                    @endif
                </div>

                <div class="right-column">

                    <b>Date</b>: {{ $concertItem->getDate() }} <br>
                    <b>Location</b>: {{ $concertItem->getLocation() }} <br>
                    <b>Capacity</b>: {{ $concertItem->getCapacity() }} <br>

                    <hr>

                    <b>Description</b>:
                    <p style="width: 400px;">{{ $concertItem->getDescription() }}</p>

                    <hr>
                    <b>Interprets</b>: <br>
                    <hr>
                    @if(session('role') == "admin" || session('role') == "organiser")
                        <a href="{{ route('concert.addInterpret', $concertItem->getId()) }}">
                            <button type="button" class="btn btn-success">Add Interpret to Concert</button>
                        </a> <br>
                    @endif
                    @foreach($concertItem->getInterpretAtConcertItems() as $interpretAtConcertItem)
                        <h4><a href="{{ route('interpret.show', $interpretAtConcertItem->getId()) }}">
                            {{ $interpretAtConcertItem->getName() }}</a></h4>
                        <b>Members</b>: {{ $interpretAtConcertItem->getMembers() }} <br>
                        <b>Genre</b>: {{ $interpretAtConcertItem->getGenre() }} <br>
                        <b>Publisher</b>: {{ $interpretAtConcertItem->getPublisher() }} <br>
                        <b>Formed at</b>: {{ $interpretAtConcertItem->getFormedAt() }} <br>

                        <b>Order</b>: {{ $interpretAtConcertItem->getOrder() }} <br>
                        <b>Date/Time</b>: {{ $interpretAtConcertItem->getDate() }} <br>
                        @if(session('role') == "admin" || session('role') == "organiser")
                            <a href="{{ route('concert.deleteInterpret', ['concertid' => $concertItem->getId(), 'concertinterpretid' => $interpretAtConcertItem->getIisInterpretidIisConcertid()]) }}">
                                <button type="button" class="btn btn-outline-danger">Delete interpret from stage</button>
                            </a>
                        @endif
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
