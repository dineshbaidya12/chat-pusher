@if (count($messages) > 0)
    @foreach ($messages as $msg)
        <div class="parent-conv reciever">
            <div class="conversations-reciever conversations">
                <p>
                    @if ($msg->status !== 'deleted')
                        {!! $msg->message ?? '' !!}
                    @else
                        <img style="padding-top:3px; opacity: .4;" src="{{ asset('assets/images/dummy-imgs/block.png') }}"
                            class="status-deleted"><span class="deleted-msg">This Message was
                            Deleted</span>
                    @endif
                </p>
            </div>
            <div class="message-time">{{ \Carbon\Carbon::parse($msg->time)->format('h:iA') }}</div>
        </div>
    @endforeach
@endif
