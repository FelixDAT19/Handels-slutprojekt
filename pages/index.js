import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import CompanyLinks from "/Components/CompanyLinks";
import CompanyList from "/Components/CompanyList";
import OpenHours from "/Components/openHours";
// component imports

import prisma from "/api/client";
//prisma client import


function Home({ sponsors, location, compaines, openHours }) {
  //start page with links to compaines and thair placements
  
  return (
    <div className="viewport">
      <MainMenu /* burger menu *//>
      <OpenHours openHours={openHours} /* sends the opening hours to openhours component */ />
      <br/>
      <CompanyList company={compaines} /* send the companies to the company list component */ />
      <br/>
      <img src="/files/lokal.png" className="imageMap" alt="lokalen" useMap="#workmap"/> {/* image used for the map */}
        
      <map name="workmap">
        <CompanyLinks location={location} /* sends all the locations to the companyLinks component *//>
        <area shape="rect" coords="38,1,82,23" alt="cafe" href={`/food`}/>   
        <area shape="rect" coords="105,1,172,23" alt="program" href={`/events`}/>   
      </map>    

      <br/>

      <FooterMenu sponsors={sponsors} /* sends all the sponsors to the sponsor component *//>
    </div>

    
  );
}

export async function getStaticProps() { // fetches sponsors and location data for links
  
  const dataSponsor = await prisma.sponsors.findMany();
  const sponsors = [...JSON.parse(JSON.stringify(dataSponsor)),]

  const dataPlacement = await prisma.placement.findMany({ orderBy: [{id: 'asc'}]});  // selects all placements orderd by id
  const location = [...JSON.parse(JSON.stringify(dataPlacement)),]

  const dataCompanies = await prisma.company.findMany({include: {placement: true,},}); // selects all companies and inclueds all placements that company has
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
  }; // retuens sponsors, location, companies and opening hours
}

export default Home;
