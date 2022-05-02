import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import LoadFood from "/Components/LoadFood";
//component imports

import prisma from "/api/client";
//prisma client import




function food({ sponsors, offers }) {
  //food page that maps out what food companys offer
  return (
    <div className="viewport">
      <MainMenu /* burger menu */ />

      <h1>Mat på plats</h1>


      <br/>

      <LoadFood offers={offers} /* sends all the offers to the loadFood component  *//>

      <FooterMenu sponsors={sponsors}  /* sends all the sponsors to the sponsor component *//>
    </div>
  );
}

export async function getStaticProps() { //fetches sponsors and offers that includes specific company data
  const dataSponsor = await prisma.sponsors.findMany();
  const sponsors = [...JSON.parse(JSON.stringify(dataSponsor))];

  const dataOffers = await prisma.company.findMany({include: {offers: true,}}) //selects all the companies and includes all offers that belong to each company
  const offers = [...JSON.parse(JSON.stringify(dataOffers))];

  return {
    props: {
      sponsors,
      offers,
    },
  }; // returns sponsors and offers
}
export default food;
