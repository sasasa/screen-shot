<form method="POST" action="{{ route('production.store') }}">
  @csrf
  <div class="inputbox">
    <div class="inputbox__inner">
      まずはWeb制作会社の情報を入力してください。公開されます。
    </div>

    <div class="inputbox__inner flex flex-col">
      会社形態：
      <label class="inputbox__item inputbox__label">
        <input class="inputbox__item inputbox__company_type" type="radio" id="" name="company_type" value="1" @checked($production->company_type==1)>法人
      </label>
      <label class="inputbox__item inputbox__label">
        <input class="inputbox__item inputbox__company_type" type="radio" id="" name="company_type" value="2" @checked($production->company_type==2)>任意団体
      </label>
      <label class="inputbox__item inputbox__label">
        <input class="inputbox__item inputbox__company_type" type="radio" id="" name="company_type" value="3" @checked($production->company_type==3)>個人・個人事業
      </label>
      @error('company_type')
        <p class="errorMessage">{{$message}}</p>
      @enderror
    </div>

    <div class="inputbox__inner flex flex-col">
      <label class="inputbox__item inputbox__label" for="name">会社名：</label>
      <input class="w-full lg:w-3/5 inputbox__item inputbox__name" type="text" id="name" name="name" value="{{ old('name', $production->name) }}">
      @error('name')
        <p class="errorMessage">{{$message}}</p>
      @enderror
    </div>

    <div class="inputbox__inner flex flex-col">
      <label class="inputbox__item inputbox__label" for="kana">会社名カナ：
      </label>
      <input class="w-full lg:w-3/5 inputbox__item inputbox__kana" type="text" id="kana" name="kana" value="{{ old('kana', $production->kana) }}">
      @error('kana')
        <p class="errorMessage">{{$message}}</p>
      @enderror
    </div>

    <div class="inputbox__inner flex flex-col">
      <label class="inputbox__item inputbox__label" for="representative">代表者：
      </label>
      <input class="w-full lg:w-3/5 inputbox__item inputbox__representative" type="text" id="representative" name="representative" value="{{ old('representative', $production->representative) }}">
      @error('representative')
        <p class="errorMessage">{{$message}}</p>
      @enderror
    </div>

    <div class="inputbox__inner flex flex-col">
      <label class="inputbox__item inputbox__label" for="postal">郵便番号：
      </label>
      <input class="w-full lg:w-3/5 inputbox__item inputbox__postal" type="text" id="postal" name="postal" value="{{ old('postal', $production->postal) }}">
      @error('postal')
        <p class="errorMessage">{{$message}}</p>
      @enderror
    </div>

    <div class="inputbox__inner flex flex-col">
      <label class="inputbox__item inputbox__label" for="address">住所：
      </label>
      <input class="w-full lg:w-3/5 inputbox__item inputbox__address" type="text" id="address" name="address" value="{{ old('address', $production->address) }}">
      @error('address')
        <p class="errorMessage">{{$message}}</p>
      @enderror
    </div>

    <div class="inputbox__inner flex flex-col">
      <label class="inputbox__item inputbox__label" for="phone">電話番号<br>※サイトを見たユーザーから直接かかってきますので取れる番号を入れてください：
      </label>
      <input class="w-full lg:w-3/5 inputbox__item inputbox__phone" type="text" id="phone" name="phone" value="{{ old('phone', $production->phone) }}">
      @error('phone')
        <p class="errorMessage">{{$message}}</p>
      @enderror
    </div>

    <div class="inputbox__inner flex flex-col">
      <label class="inputbox__item inputbox__label" for="inquiry_email">お問い合わせ先Email<br>※サイトを見たユーザーから届きますので必ず目を通すアドレスを入れてください：
      </label>
      <input class="w-full lg:w-3/5 inputbox__item inputbox__inquiry_email" type="email" id="inquiry_email" name="inquiry_email" value="{{ old('inquiry_email', $production->inquiry_email) }}">
      @error('inquiry_email')
        <p class="errorMessage">{{$message}}</p>
      @enderror
    </div>

    <div class="inputbox__inner flex flex-col">
      <label class="inputbox__item inputbox__label" for="url">ホームページURL：
      </label>
      <input class="w-full lg:w-3/5 inputbox__item inputbox__url" type="text" id="url" name="url" value="{{ old('url', $production->url) }}">
      @error('url')
        <p class="errorMessage">{{$message}}</p>
      @enderror
    </div>

    <div class="inputbox__inner flex flex-col">
      スタッフ数：
      <label class="inputbox__item inputbox__label">
        <input class="inputbox__item inputbox__staff" type="radio" id="" name="staff" value="1" @checked($production->staff==1)>1人
      </label>
      <label class="inputbox__item inputbox__label">
        <input class="inputbox__item inputbox__staff" type="radio" id="" name="staff" value="2" @checked($production->staff==2)>2人～5人
      </label>
      <label class="inputbox__item inputbox__label">
        <input class="inputbox__item inputbox__staff" type="radio" id="" name="staff" value="3" @checked($production->staff==3)>6人～9人
      </label>
      <label class="inputbox__item inputbox__label">
        <input class="inputbox__item inputbox__staff" type="radio" id="" name="staff" value="4" @checked($production->staff==4)>10人～19人
      </label>
      <label class="inputbox__item inputbox__label">
        <input class="inputbox__item inputbox__staff" type="radio" id="" name="staff" value="5" @checked($production->staff==5)>20人～49人
      </label>
      <label class="inputbox__item inputbox__label">
        <input class="inputbox__item inputbox__staff" type="radio" id="" name="staff" value="6" @checked($production->staff==6)>50人～99人
      </label>
      <label class="inputbox__item inputbox__label">
        <input class="inputbox__item inputbox__staff" type="radio" id="" name="staff" value="7" @checked($production->staff==7)>100人以上
      </label>
      @error('staff')
        <p class="errorMessage">{{$message}}</p>
      @enderror
    </div>

    <div class="inputbox__inner flex flex-col">
      <label class="inputbox__item inputbox__label" for="achievement">主な実績</label>
      <textarea class="h-64 w-full lg:w-3/5 inputbox__item inputbox__textarea" id="achievement" name="achievement">{{ old('achievement', $production->achievement) }}</textarea>
      @error('achievement')
      <p class="errorMessage">{{$message}}</p>
      @enderror
    </div>

    <div class="inputbox__inner flex flex-col">
      <label class="inputbox__item inputbox__label" for="introduction">会社概要</label>
      <textarea class="h-64 w-full lg:w-3/5 inputbox__item inputbox__textarea" id="introduction" name="introduction">{{ old('introduction', $production->introduction) }}</textarea>
      @error('introduction')
      <p class="errorMessage">{{$message}}</p>
      @enderror
    </div>

    <div class="inputbox__inner flex-container">
      <button class="form-input inputbox__item inputbox__submit" type="submit">登録</button>
    </div>

  </div>
</form>