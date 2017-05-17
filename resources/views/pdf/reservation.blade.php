<style>
    .coupon {
        width: 200px;
        height: 180px;
        border: 1px dotted;
        margin: 10px;
        padding: 10px;
    }
</style>

<h2>Reservatienummer 1{{--{{ $reservatie->id }}--}}</h2>

<p>Naam: {{ $bezoeker['naam'] }}</p>
<p>Email: {{ $bezoeker['email'] }}</p>
<p>Betaalmethode: {{ $reservatie['payment'] }}</p>
<p>Totaal prijs: &euro;{{ $prijs }}</p>

<table style="width: 100%">
    <tr>
        <td>Tickets</td>
    </tr>
    @foreach ($tickets_chunks as $tickets)
        <tr>
            @foreach ($tickets as $ticket)
                <td>
                    <div class="coupon">
                        <b>Ticket</b><br>
                        {{ $ticket['titel'] }}<br>
                        &euro;&nbsp;{{ $ticket['prijs'] }}<br>
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(130)->generate($ticket['token'])) !!} ">
                    </div>
                </td>
            @endforeach
        </tr>
    @endforeach
</table>

<table style="width: 100%">
    <tr>
        <td>Maaltijden</td>
    </tr>
    @foreach ($maaltijden_chunks as $maaltijden)
        <tr>
            @foreach ($maaltijden as $maaltijd)
                <td>
                    <div class="coupon">
                        <b>Maaltijd</b><br>
                        {{ $maaltijd['titel'] }}<br>
                        &euro;&nbsp;{{ $maaltijd['prijs'] }}<br>
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(130)->generate($maaltijd['token'])) !!} ">
                    </div>
                </td>
            @endforeach
        </tr>
    @endforeach
</table>