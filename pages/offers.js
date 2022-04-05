import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import { PrismaClient } from "@prisma/client";
import LoadOffers from "/Components/LoadOffers";
const prisma = new PrismaClient();

function offers({ sponsors, offers }) {
  //Erbjudandesidan
  return (
    <>
      <MainMenu />

      <h1>Erbjudanden</h1>

      <br/>

      <LoadOffers offers={offers}/>

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
export default offers;
