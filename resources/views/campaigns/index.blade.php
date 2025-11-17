<h1>HelpHive Campaigns</h1>
@foreach($campaigns as $campaign)
    <div>
        <h3>{{ $campaign->title }}</h3>
        <p>{{ $campaign->description }}</p>
        <a href="{{ route('campaign.show', $campaign->id) }}">View</a>
    </div>
@endforeach
