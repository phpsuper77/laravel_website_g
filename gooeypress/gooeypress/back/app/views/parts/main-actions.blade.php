<div class="main_actions" id="js_main_actions" data-toggle-allow-overflow-y="true">
    <div class="main_actions_inner std_width">
        <div class="float_left">
            <a href="#" id="btn-refine-filters" class="btn btn_subdued btn_refine_categories"><span class="icon-menu"></span> Refine your categories</a>

            <ul class="reset menu main_actions_menu">
                <li class="dropdown_parent">
                    <a href="#">Genre</a>
                    <ul class="dropdown_menu">
                        @foreach($genres as $genre)
                        <li><a href="{{ route('themes.index') }}?filter=true&genre={{ $genre->id }}">{{ $genre->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="dropdown_parent">
                    <a href="#">Style</a>
                    <ul class="dropdown_menu">
                        @foreach($styles as $style)
                            <li><a href="{{ route('themes.index') }}?filter=true&style={{ $style->id }}">{{ $style->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="dropdown_parent">
                    <a href="#">Layout</a>
                    <ul class="dropdown_menu">
                        @foreach($layouts as $layout)
                            <li><a href="{{ route('themes.index') }}?filter=true&layout={{ $layout->id }}">{{ $layout->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>

        @if (Auth::check())
            <div class="saved_themes">
                <h3 class="saved_themes_heading"><a href="{{ url('/account/themes') }}"><span class="icon-pin"></span>Saved <span class="selecive_display_block">Themes</span></a></h3>
                <?php $themes = Auth::user()->savedThemes->slice(0, 3); ?>
                <ul class="reset saved_theme_list">
                    @foreach ($themes as $theme)
                        <li class="inline_block"><a href="{{ url('/themes/remove/'. $theme->id) }}" class="btn btn_subdued btn_saved_theme"><span class="icon-pin"></span><span class="hidden">Remove</span> {{ $theme->title }} <span class="icon-cross"></span></a></li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
