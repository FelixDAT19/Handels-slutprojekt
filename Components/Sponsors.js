import Link from "next/link";

function Sponsors({sponsors}){
    return(
        <div id="sponsor">

            {sponsors.map(({logoUrl,sponsorUrl,name}, i) => ( //maps out sponsors
                <div key={i}>
                    
<<<<<<< HEAD
                    <Link href={sponsorUrl} className="sponsorHomepage" passHref><img src={logoUrl} alt="sponsorimgae" className="sponsorImage"></img></Link>
=======
                    <a passHref={true} href={sponsorUrl} className="sponsorHomepage" dangerouslySetInnerHTML={{__html: `<img src="${logoUrl}" alt="sponsor image" class="sponsorImage"/>`}}/>
>>>>>>> 1132ebedc7e320d4e29c213559f7866af4276cb1
                    <p className="sponsorInfo">{name}</p>
                    <br/>
                </div>
            ))}

        </div>
    )

}

export default Sponsors;