import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import prisma from "/api/client";
import LoadFood from "/Components/LoadFood";



function food({ sponsors, offers }) {
  //food page that maps out what food companys offer
  return (
    <div className="viewport">
      <MainMenu />

      <h1>Mat på plats</h1>


      <br/>

      <LoadFood offers={offers}/>

      <FooterMenu sponsors={sponsors} />
    </div>
  );
}

export async function getStaticProps() { //fetches sponsors and offers that includes specific company data
  const dataSponsor = await prisma.sponsors.findMany();
  const sponsors = [...JSON.parse(JSON.stringify(dataSponsor))];

  const dataOffers = await prisma.company.findMany({include: {offers: true,}})
  const offers = [...JSON.parse(JSON.stringify(dataOffers))];

  return {
    props: {
      sponsors,
      offers,
    },
  };
}
export default food;
