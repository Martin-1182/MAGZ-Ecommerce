<template>
    <div class="blog-section">
        <div class="container">
            <h1 class="text-center">
                Z nášho blogu
            </h1>

            <p class="section-description">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore
                vitae nisi, consequuntur illum dolores cumque pariatur quis
                provident deleniti nesciunt officia est reprehenderit sunt
                aliquid possimus temporibus enim eum hic.
            </p>

            <div class="blog-posts">
                <div v-for="post in posts" :key="post.id" class="blog-post">
                    <a :href="post.link"
                        ><blog-image
                            :url="post._links['wp:featuredmedia'][0].href"
                    /></a>
                    <a :href="post.link">
                        <h2 class="blog-title">{{ post.title.rendered }}</h2>
                    </a>
                    <div class="blog-description">
                        {{ shorten(stripTags(post.excerpt.rendered), 200) }}
                    </div>
                </div>
            </div>
        </div>
        <!-- end container -->
    </div>
    <!-- end blog-section -->
</template>

<script>
import BlogImage from "./BlogImage";
import sanitizeHtml from "sanitize-html";
export default {
    data() {
        return {
            posts: []
        };
    },
    components: {
        BlogImage
    },
    created() {
        axios
            .get(
                "https://blog-ecommerce.websystem.sk/index.php/wp-json/wp/v2/posts?per_page=3"
            )
            .then(response => {
                this.posts = response.data;
            });
    },
    methods: {
        shorten(text, len = 50) {
            return _.truncate(text, { length: len });
        },
        stripTags(html) {
            return sanitizeHtml(html, {
                allowedTags: []
            }).substring(0, html.indexOf("&hellip;"));
        }
    }
};
</script>

<style lang="scss" scoped></style>
