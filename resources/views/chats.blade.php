{{-- <div class="parent-conv reciever">
    <div class="conversations-reciever conversations">
        <p>
            Lorem Ipsum Doller si
        </p>
    </div>
    <div class="message-time">12:50</div>
</div>

<div class="conversation-time">
    <p>Today</p>
</div>

<div class="parent-conv reciever">
    <div class="conversations-reciever conversations">
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, dicta
            reprehenderit delectus accusamus reiciendis vero sint dolorum impedit
            atque
            quod labore voluptates asperiores commodi qui quibusdam alias, amet
            exercitationem. Dolores.
        </p>
    </div>
    <div class="message-time">19:06</div>
</div>

<div class="spacer-10"></div>

<div class="parent-conv sender">
    <div class="conversations-sender conversations">
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, dicta
            reprehenderit delectus accusamus reiciendis vero sint dolorum impedit
            atque
            quod labore voluptates asperiores commodi qui quibusdam alias, amet
            exercitationem. Dolores.
        </p>
    </div>
    <div class="message-time">19:06</div>
</div> --}}

@if (count($messages) > 0)
    @php
        $lastFormattedDate = null;
        $lastSendedType = null;
    @endphp
    @foreach ($messages as $msg)
        @php
            $carbonTime = \Carbon\Carbon::parse($msg->time);
            $now = \Carbon\Carbon::now();
            $formattedDate = '';
            if ($carbonTime->isToday()) {
                $formattedDate = 'Today';
            } elseif ($carbonTime->isYesterday()) {
                $formattedDate = 'Yesterday';
            } elseif ($carbonTime->diffInDays($now) == 1) {
                $formattedDate = $carbonTime->diffInDays($now) . ' day ago';
            } elseif ($carbonTime->diffInDays($now) <= 3) {
                $formattedDate = $carbonTime->diffInDays($now) . ' days ago';
            } else {
                $formattedDate = $carbonTime->format('F j, Y');
            }
        @endphp
        @if ($formattedDate !== $lastFormattedDate)
            <div class="conversation-time">
                <p>{{ $formattedDate }}</p>
            </div>
        @endif
        @php
            $lastFormattedDate = $formattedDate;
        @endphp
        @if ($msg->sender == auth()->user()->id)
            <div class="parent-conv sender">
                <div class="conversations-sender conversations">
                    <p>
                        @if ($msg->status !== 'deleted')
                            {!! $msg->message ?? '' !!}
                        @else
                            <img style="padding-top:3px; opacity: .4;"
                                src="{{ asset('assets/images/dummy-imgs/block.png') }}" class="status-deleted"><span
                                class="deleted-msg">This Message was
                                Deleted</span>
                        @endif
                    </p>
                </div>
                <div class="message-time">{{ \Carbon\Carbon::parse($msg->time)->format('h:iA') }}</div>
            </div>
        @else
            <div class="parent-conv reciever">
                <div class="conversations-reciever conversations">
                    <p>
                        @if ($msg->status !== 'deleted')
                            {!! $msg->message ?? '' !!}
                        @else
                            <img style="padding-top:3px; opacity: .4;"
                                src="{{ asset('assets/images/dummy-imgs/block.png') }}" class="status-deleted"><span
                                class="deleted-msg">This Message was
                                Deleted</span>
                        @endif
                    </p>
                </div>
                <div class="message-time">{{ \Carbon\Carbon::parse($msg->time)->format('h:iA') }}</div>
            </div>
        @endif
    @endforeach
@else
    <div class="no-conv-div">
        <p class="no-conv">No Conversation Yet</p>
    </div>
@endif

<script>
    $(document).ready(function() {
        $('#chat-with').text("{{ $otherPersoneName }}");
        $('#chat-with-img').attr('src', "{{ $otherPersonImage }}");
    });
</script>
