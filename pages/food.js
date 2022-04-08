import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import prisma from "/api/client";
import LoadFood from "/Components/LoadFood";



function food({ sponsors, offers }) {
  //food page that maps out what food companys offer
  return (
    <>
      <MainMenu />

      <h1>Mat på plats</h1>

      <div class="btn">Matställe 1</div>
      <div class="btn">Matställe 2</div>
      <div class="btn">Matställe 3</div>
      <div class="btn">Matställe 4</div>
      <div class="backbutton">Tillbaka</div>

      <br/>

      <LoadFood offers={offers}/>

      <FooterMenu sponsors={sponsors} />
    </>
  );
}

export async function getStaticProps() { //fetches sponsors and offers that includes specific company data
  const dataSponsor = await prisma.sponsors.findMany();
  const sponsors = [...JSON.parse(JSON.stringify(dataSponsor))];

  const dataOffers = await prisma.offers.findMany({include: {company: true,}})
  const offers = [...JSON.parse(JSON.stringify(dataOffers))];

  return {
    props: {
      sponsors,
      offers,
    },
  };
}
export default food;
