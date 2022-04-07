import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import CompanyLinks from "/Components/CompanyLinks";
import prisma from "/api/client";

function Home({ sponsors, location }) {
  
  return (
    <>
      <MainMenu />
      <hr/>
      <CompanyLinks location={location}/>

      <FooterMenu sponsors={sponsors}/>
    </>

    //startsida med länk
  );
}

export async function getStaticProps() {
  
  const dataSponsor = await prisma.sponsors.findMany();
  const sponsors = [...JSON.parse(JSON.stringify(dataSponsor)),]

  const dataPlacement = await prisma.placement.findMany({ orderBy: [{id: 'asc'}]}); 
  const location = [...JSON.parse(JSON.stringify(dataPlacement)),]



  return {
    props: {
      sponsors,
      location,
    },
  };
}

export default Home;
