{{--<script src="https://cdn.tailwindcss.com"></script>--}}

{{--@filamentStyles--}}
@libraryStyles
@include('catalyst::components.layouts.partials.fontawesome')
{{--@vite(['public/css/omnia-digital/catalyst-core-plugin/catalyst-core-plugin-styles.css'])--}}
{{--@vite(['public/css/omnia-digital/catalyst-core-plugin/catalyst-social-styles.css'])--}}
{{--@vite(['public/css/omnia-digital/catalyst-core-plugin/catalyst-admin-styles.css'])--}}
{{--@vite(['public/css/omnia-digital/catalyst-core-plugin/catalyst-jobs-styles.css'])--}}
@stack('styles')
