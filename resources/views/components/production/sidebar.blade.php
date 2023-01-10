<div>
    <h3>今月のお問合せ({{ $inquiries->count() }})</h3>
    <div class="contacts">
    <ul>
    @forelse ($inquiries as $inquiry)
        <li>
            {{ $inquiry->typeName }}:
            {{ $inquiry->created_at }}
        </li>
    @empty
        <li>
            問い合わせはありません。
        </li>
    @endforelse
    </ul>
    </div>

    <h3>先月のお問合せ({{ $inquiries_last_month->count() }})</h3>
    <div class="contacts">
    <ul>
    @forelse ($inquiries_last_month as $inquiry)
        <li>
            {{ $inquiry->typeName }}:
            {{ $inquiry->created_at }}
        </li>
    @empty
        <li>
            問い合わせはありません。
        </li>
    @endforelse
    </ul>
    </div>
</div>