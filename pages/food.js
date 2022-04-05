import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import { PrismaClient } from "@prisma/client";
import LoadFood from "/Components/LoadFood";
const prisma = new PrismaClient();


function food({ sponsors, offers }) {
  //meny
  return (
    <>
      <MainMenu />

      <h1>Mat på plats</h1>

      <br/>

      <LoadFood offers={offers}/>

      <FooterMenu sponsors={sponsors} />
    </>
  );
}

export async function getStaticProps() {
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
