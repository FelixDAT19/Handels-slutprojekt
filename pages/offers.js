import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import { PrismaClient } from "@prisma/client";
const prisma = new PrismaClient();

function offers({ sponsors }) {
  //Erbjudandesidan
  return (
    <>
      <MainMenu />

      <h1>Erbjudanden</h1>

      <FooterMenu sponsors={sponsors} />
    </>
  );
}

export async function getStaticProps() {
  const dataSponsor = await prisma.sponsors.findMany();
  const sponsors = [...JSON.parse(JSON.stringify(dataSponsor))];

  return {
    props: {
      sponsors,
    },
  };
}
export default offers;
