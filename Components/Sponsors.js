import Link from "next/link";

function Sponsors({sponsors}){
    return(
        <div id="sponsor">

            {sponsors.map(({logoUrl,sponsorUrl,name}, i) => ( //maps out sponsors
                <div key={i}>
                    
                    <Link href={sponsorUrl} className="sponsorHomepage" passHref><img src={logoUrl} alt="sponsorimgae" className="sponsorImage"></img></Link>
                    <p className="sponsorInfo">{name}</p>
                    <br/>
                </div>
            ))}

        </div>
    )

}

export default Sponsors;