<script>
  import Layout from "@public-shared/Layout";
  import Slider from "@public-pages/Home/Slider";
  import InfoBoxes from "@public-pages/Home/InfoBoxes";
  import FeaturedProducts from "@public-pages/Home/FeaturedProducts";
  import FirstBanner from "@public-pages/Home/FirstBanner";
  import BestSellers from "@public-pages/Home/BestSellers";
  import ProductCategories from "@public-pages/Home/ProductCategories";
  import NewArrivals from "@public-pages/Home/NewArrivals";
  import LatestArticles from "@public-pages/Home/LatestArticles";
  import TopBrands from "@public-pages/Home/TopBrands";
  import SpecialOffers from "@public-pages/Home/SpecialOffers";
  import { Inertia } from "@inertiajs/inertia";
  import { page } from "@inertiajs/inertia-svelte";
  import route from "ziggy";

  $: ({ errors, app } = $page);
</script>

<Layout>

  <Slider />
  <InfoBoxes />
  <FeaturedProducts />
  <FirstBanner />
  <BestSellers />
  <ProductCategories />
  <NewArrivals />
  <LatestArticles />
  <TopBrands />
  <SpecialOffers />

</Layout>
