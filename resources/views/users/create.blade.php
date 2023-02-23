<form method="post" action="" enctype="multipart/form-data" id="create-user-form">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" />
        @if ($errors->has('name'))
            <span class="error">{{ $errors->first('name') }}</span>
        @endif
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
        @if ($errors->has('email'))
            <span class="error">{{ $errors->first('email') }}</span>
        @endif
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone">
        @if ($errors->has('phone'))
            <span class="error">{{ $errors->first('phone') }}</span>
        @endif
    </div>
    <fieldset>
        <legend>Gender</legend>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male">
            <label class="form-check-label" for="gender_male">
                Male
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female">
            <label class="form-check-label" for="gender_female">
                Female
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="gender_other" value="other">
            <label class="form-check-label" for="gender_other">
                Other
            </label>
        </div>
        @if ($errors->has('gender'))
            <span class="error">{{ $errors->first('gender') }}</span>
        @endif
    </fieldset>

    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" name="image" id="image" accept="image/*">
        @if ($errors->has('image'))
            <span class="error">{{ $errors->first('image') }}</span>
        @endif
    </div>
    <div class="mb-3">
        <label for="file" class="form-label">File</label>
        <input type="file" class="form-control" id="file" name="file">
        @if ($errors->has('file'))
            <span class="error">{{ $errors->first('file') }}</span>
        @endif
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input @error('phone') is-invalid @enderror" name="terms"
            id="terms">
        <label class="form-check-label" for="terms">Accept terms and condition</label>
        @if ($errors->has('terms'))
            <span class="error">{{ $errors->first('terms') }}</span>
        @endif
    </div>
</form>
