import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import CompanyLinks from "/Components/CompanyLinks";
import prisma from "/api/client";
import CompanyList from "/Components/CompanyList";
import OpenHours from "/Components/openHours";

function Home({ sponsors, location, compaines, openHours }) {
  //start page with links to compaines and thair placements
  
  return (
    <div className="viewport">
      <MainMenu />
      <OpenHours openHours={openHours}/>
      <br/>
      <CompanyList company={compaines}/>
      <br/>
      <img src="/files/lokal.png" className="imageMap" alt="lokalen" useMap="#workmap"/>
        
      <map name="workmap">
        <CompanyLinks location={location}/>
        <area shape="rect" coords="38,1,82,23" alt="cafe" href={`/food`}/>   
        <area shape="rect" coords="105,1,172,23" alt="program" href={`/events`}/>   
      </map>    

      <br/>

      <FooterMenu sponsors={sponsors}/>
    </div>

    
  );
}

export async function getStaticProps() { // fetches sponsors and location data for links
  
  const dataSponsor = await prisma.sponsors.findMany();
  const sponsors = [...JSON.parse(JSON.stringify(dataSponsor)),]

  const dataPlacement = await prisma.placement.findMany({ orderBy: [{id: 'asc'}]}); 
  const location = [...JSON.parse(JSON.stringify(dataPlacement)),]

  const dataCompanies = await prisma.company.findMany({include: {placement: true,},});
  const compaines = [...JSON.parse(JSON.stringify(dataCompanies)),]

  const dataOpenHours = await prisma.openhours.findMany();
  const openHours = [...JSON.parse(JSON.stringify(dataOpenHours)),]


  return {
    props: {
      sponsors,
      location,
      compaines,
      openHours,
    },
  };
}

export default Home;
