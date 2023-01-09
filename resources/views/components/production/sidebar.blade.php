<div>
    <h3>新着問い合わせ</h3>
    <div class="contacts">
    @forelse ($contacts as $contact)
        問い合わせはあります。
    @empty
        問い合わせはありません。
    @endforelse
    </div>
</div>