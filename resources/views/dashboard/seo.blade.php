<h4 style="margin-top: 20px;">SEO</h4>

<div class="input-group clearfix" id="name-group">
    <div class="pull-left">
        <input type="text" placeholder="Title" value="{{ old('seo_title', $title ?? '') }}" name="seo_title">

        @error('seo_title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="pull-right">
        <input type="text" placeholder="Keywords" value="{{ old('seo_keywords', $keywords ?? '') }}" name="seo_keywords">

        @error('seo_keywords')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<textarea placeholder="Description" name="seo_description" rows="5">{{ old('seo_description', $description ?? '') }}</textarea>

@error('seo_description')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror