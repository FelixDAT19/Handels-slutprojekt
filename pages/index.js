import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import CompanyLinks from "/Components/CompanyLinks";
import prisma from "/api/client";

function Home({ sponsors, location }) {
  //start page with links to compaines and thair placements
  return (
    <>
      <MainMenu />
      <hr/>


      <img src="/files/lokal.png" className="imageMap" useMap="#workmap"/>
        
      <map name="workmap">
        <CompanyLinks location={location}/>
      </map>

      <FooterMenu sponsors={sponsors}/>
    </>

    
  );
}

export async function getStaticProps() { // fetches sponsors and location data for links
  
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
