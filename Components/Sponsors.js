import Link from "next/link";

function Sponsors({sponsors}){
    return(
        <div id="sponsor">

            {sponsors.map(({logoUrl,sponsorUrl,name}, i) => ( //maps out sponsors
                <div key={i}>
                    
                    <Link href={sponsorUrl} className="sponsorHomepage" passHref><img src={logoUrl} alt={name} className="sponsorImage"></img></Link>
                   
                    <br/>
                </div>
            ))}

        </div>
    )

}

export default Sponsors;